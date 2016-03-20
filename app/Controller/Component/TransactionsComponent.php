<?php
App::uses('Component', 'Controller');

/**
 * トランザクションで利用する関数を集約する
 */
class TransactionsComponent extends Component {

	//コンポーネントをロード
    public $components = array(
    	'Caches',
    	'Session'
    );

    /**
     * トランザクション実行
     * トランザクション実行中は、キャッシュに実行中であることを登録
     * @param  int   $func_name
     * @return array
     */
	public function start($func_name){

		//返却値を設定
		$result = array();

		//引数をチェック
		if(empty($func_name)){
			$result;
		}

        //モデルをロード
        $TransactionManager = ClassRegistry::init('TransactionManager');

        //同一ユーザがーがトランザクション中かを確認
        $is_in_transaction = $this->checkIsInTransaction($func_name);
        if($is_in_transaction === true){
        	//実行中の場合は空配列で返却
            return $result;
        }

        //トランザクションを開始
        $is_success_register_cache = $this->registerTransactionCache($func_name);
        if($is_success_register_cache === false){
        	//キャッシュ登録に失敗した場合、空配列で返却
        	return $result;
        }

        //トランザクション開始
		$result = $TransactionManager->begin();

        return $result;
	}

    /**
     * トランザクション終了
     * @param  boolean   $flg
     * @param  object    $transaction
     * @param  string    $func_name
     * @return array
     */
	public function end($flg, $transaction, $func_name){

		//返却値を設定
		$result = array();

		//引数をチェック
		if(empty($flg) || empty($transaction) || empty($func_name)){
			$result;
		}

        //モデルをロード
        $TransactionManager = ClassRegistry::init('TransactionManager');

        //コミット or ロールバック
        if($flg === true){
			//コミット
			$TransactionManager->commit($transaction);
        } else {
        	//ロールバック
        	$TransactionManager->rollback($transaction);	
        }

        //連打対策解除
        $name 	= $this->Session->read('Auth.id');

        //フォルダ名
        $folder_name = "transaction";

        //キャッシュ削除
        $data = $this->Caches->clearOne($folder_name, $name, $func_name);

	}

    /**
     * トランザクション実行中判定する
     * @param  int   $func_name
     * @return array
     */
	public function checkIsInTransaction($func_name){

		//返却値を設定
		$result = false;

		//引数の存在確認
		if(empty($func_name)){
			return $result;
		}

        //モデルをロード
        $TransactionManager = ClassRegistry::init('TransactionManager');

        //キャッシュ名
        $name = $this->Session->read('Auth.id');

        //キャッシュパスを取得
        $path = $TransactionManager->getUserCachePath(CACHE_USERS_TRANSACTION, $func_name);

        //キャッシュを取得
        $is_in_transaction = $this->Caches->read($path, $name);

        //返却値を設定
        if($is_in_transaction === false){
        	$result = false;
        } else {
        	$result = true;
        }

        return $result;

	}

    /**
     * トランザクション実行中登録
     * @param  int   $func_name
     * @return array
     */
	public function registerTransactionCache($func_name){

		//返却値を設定
		$result = false;

		//引数の存在確認
		if(empty($func_name)){
			return $result;
		}

        //モデルをロード
        $TransactionManager = ClassRegistry::init('TransactionManager');

        //キャッシュパスを取得
        $path 		= $TransactionManager->getUserCachePath(CACHE_USERS_TRANSACTION, $func_name);

        //キャッシュ名
        $name 	= $this->Session->read('Auth.id');

        //キャッシュの値
        $value 	= Configure::read('TRANSACTION_CACHE_VALUE');

        //キャッシュの有効期限
        $duration 		= Configure::read('TRANSACTION_DURATION');  

        //キャッシュを保存
        $result = $this->Caches->write($path, $name, $value, $duration);

        return $result;

	}



}