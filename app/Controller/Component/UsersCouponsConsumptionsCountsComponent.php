<?php
App::uses('Component', 'Controller');

/**
 * ユーザーのクーポン消費枚数で利用する関数を集約する
 */
class UsersCouponsConsumptionsCountsComponent extends Component {

	//コンポーネントをロード
    public $components = array(
    	'Session'
    );

    /**
     * ユーザーのクーポン消費枚数を取得
     * @return array
     */
    public function getRecord(){

        //変数の初期値を設定
        $result = array();

        //ユーザー情報を取得
        $user_data = $this->Session->read('Auth');
        if(empty($user_data)){
            return $result;
        }

        //ユーザーid
        $user_id = $user_data['User']['id'];

        //現在の年月（数字6桁）
        $yearmonth = intval(date('Ym'));

        //消費数を取得
        $UsersCouponsConsumptionsCount  = ClassRegistry::init('UsersCouponsConsumptionsCount');
        $result = $UsersCouponsConsumptionsCount->find('first', array(
            'conditions' => array(
                'user_id'   => $user_data['User']['id'],
                'yearmonth' => $yearmonth
            )
        ));

        return $result;
    }

    /**
     * ユーザーのクーポン消費枚数を保存
     * @return array
     */
	public function createRecord($coupon_id){

        //変数の初期値を設定
        $result = array();

        //引数がない場合
        if(is_null($coupon_id) || !is_numeric($coupon_id)){
            return $result;
        }

    	//ユーザー情報を取得
        $user_data = $this->Session->read('Auth');
        if(empty($user_data)){
            return $result;
        }

        //ユーザーid
        $user_id = $user_data['User']['id'];

        //現在の年月（数字6桁）
        $yearmonth = intval(date('Ym'));

        //現在のレコード消費数を取得
        $UsersCouponsConsumptionsCount  = ClassRegistry::init('UsersCouponsConsumptionsCount');
        $record = $UsersCouponsConsumptionsCount->find('first', array(
        	'conditions' => array(
        		'user_id' 	=> $user_data['User']['id'],
        		'yearmonth' => $yearmonth
        	)
        ));

        //現在のレコード数を取得
        if(empty($record)){
        	$count = 0;
        } else {
        	$count = intval($record['count']);
        }

        //保存・更新後の消費数を取得
        $new_count = $count + 1;

        //saveする情報を定義
        $data['user_id']                      = $user_id;
        $data['yearmonth']                    = $yearmonth;
        $data['count']		                  = $new_count;
        $data['last_consumed_coupon_id']      = $coupon_id;

        //レコードがない場合
        if(empty($record)){
        	//createする
        	$UsersCouponsConsumptionsCount->create();
        	//sql実行
        	$result = $UsersCouponsConsumptionsCount->save($data);
        } else {
        //レコードがある場合
        	//idを指定
        	$data['id']                      = $record['id'];
        	//フィールドを指定
        	$fields = array('count', 'last_consumed_coupon_id');
        	//sql実行
        	$result = $UsersCouponsConsumptionsCount->save($data, false, $fields);
        }

        return $result;

	}

}