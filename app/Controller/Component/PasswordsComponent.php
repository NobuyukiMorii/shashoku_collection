<?php
App::uses('Component', 'Controller');

/**
 * パスワードに関連する関数を集約する
 */
class PasswordsComponent extends Component {

	//コンポーネントをロード
    public $components = array(
    	'Users',
    	'Session',
    	'Auth',
    	'Transactions'
    );

    /**
     * コントローラーを読み込む
     */
    public function initialize(Controller $controller) {

        $this->Controller = $controller;

    }

    /**
     * パスワードのバリデーション
     */
    public function updateValidation($password, $password_confirm) {

    	//返却値を設定
    	$result = array(
    		'error_code' 	=> 0,
    		'error_message' => ''
    	);

        //フォーム未入力
        if(empty($password) || empty($password_confirm)){

            $result['error_code'] = Configure::read('ERR_CODE_NO_PARAM');
            $result['error_message'] = __('パスワードが送信されていません');
            return $result;

        }

        //確認用が異なる場合
        if($password !== $password_confirm){

            $result['error_code'] = Configure::read('ERR_CODE_NOT_SUITABLE_PARAM');
            $result['error_message'] = __('確認用のパスワードが異なります');
            return $result;
        }

        //半角英数記号
        $preg_match_flg = preg_match("/^[!-~]+$/", $password);
        if($preg_match_flg === 0){

            $result['error_code'] = Configure::read('ERR_CODE_NOT_SUITABLE_PARAM');
            $result['error_message'] = __('半角英数記号でご入力下さい');
            return $result;
        } 

        //文字数チェック
        $password_length = mb_strlen($password,"UTF-8");
        if($password_length < Configure::read('LOGIN_PASSWORD_LEMGTH_MIN') || $password_length > Configure::read('LOGIN_PASSWORD_LEMGTH_MAX')){

            $result['error_code'] = Configure::read('ERR_CODE_NOT_SUITABLE_PARAM');
            $result['error_message'] = __('指定の長さのパスワードを入力して下さい');
            return $result;
        }

        return $result;

    }    

    /**
     * パスワードのハッシュ化
     */
    public function encrypt($password) {

    	//引数のチェック
    	if(empty($password)){
    		return $result;
    	}

        //hashTypeを取得
        $hashType = $this->Controller->components['Auth']['authenticate']['Form']['passwordHasher']['hashType'];

        //暗号化する
        $password = Security::hash($password, $hashType, true);

        return $password;

    }

    /**
     * ユーザー情報をアップデート
     */
    public function update($user_id, $password) {

    	//返却値を設定
    	$result = false;

        //----------------------------------------
        //バリデーション
        //----------------------------------------

    	//ユーザーidかパスワードがない場合
    	if(empty($user_id) || empty($password)){
			//更新しない
    		return $result;
    	}

    	//ユーザーの存在を確認
		$user_existence = $this->Users->checkUserExistence($user_id);
		//ユーザーが存在しない場合
		if($user_existence === false){
			//更新しない
			return $result;
		}

        //----------------------------------------
        //セッション情報バックアップ
        //----------------------------------------

        //更新前のセッション情報を取得しておく
        $before_update_auth_session = $this->Session->read('Auth');

        //----------------------------------------
        //DB情報更新
        //----------------------------------------

        //モデルをロード
        $User = ClassRegistry::init('User');

        //トランザクション開始
        $transaction = $this->Transactions->start(__FUNCTION__);

        //トランザクション開始に失敗した場合
        if(empty($transaction)){
            return $result;
        }

        try{

        	//ユーザーidをモデルに設定
			$User->id = $user_id;

            //DB更新
            $db_result = $User->saveField('password', $password);

            //DB更新に成功した場合
            if($db_result !== false){

		        //セッション更新
		        $session_result = $this->Session->write('Auth.User.password', $password);

		        //セッション更新に成功した場合
		        if($session_result === true){
					//コミット
					$this->Transactions->end(true, $transaction, __FUNCTION__);
		        } else {

		        	//セッションロールバック
					$this->Session->write('Auth', $before_update_auth_session);

					//DBロールバック
					$this->Transactions->end(false, $transaction, __FUNCTION__);  	
					return $result;
		        }

            } else {
			//DB更新に失敗した場合
				//ロールバック
				$this->Transactions->end(false, $transaction, __FUNCTION__);
				return $result;
            }

        } catch(Exception $e) {
        //DB更新失敗した場合
			//ロールバック
			$this->Transactions->end(false, $transaction, __FUNCTION__);
        	return $result;
        }

        //返却値に更新情報を格納
        $result = $db_result;

        return $result;

    }

}