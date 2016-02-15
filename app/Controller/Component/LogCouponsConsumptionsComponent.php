<?php
App::uses('Component', 'Controller');

/**
 * クーポン消費ログに関連利用する関数を集約する
 */
class LogCouponsConsumptionsComponent extends Component {

	//コンポーネントをロード
    public $components = array(
    	'Coupons',
    	'Session'
    );

    /**
     * クーポン消費ログを作成する
     * @param array $coupon_id
     * @return array 
     */
    public function createLog($coupon_id){

        //変数の初期値を設定
        $result = array();

        //引数がない場合
        if(is_null($coupon_id) || !is_numeric($coupon_id)){
            return $result;
        }

        //saveする情報を取得
        $save_data = $this->getOneCouponForLog($coupon_id);
        if(empty($save_data)){
            return $result;
        }

        //モデルをロード
        $LogCouponsConsumption  = ClassRegistry::init('LogCouponsConsumption');

        //saveを指定（updateではない）
        $LogCouponsConsumption->create();

        //クーポン消費ログを保存
        $result = $LogCouponsConsumption->save($save_data);

        return $result;

    }

    /**
     * クーポン消費ログに必要なデータを取得
     * @param array $coupon_id
     * @return array 
     */
	public function getOneCouponForLog($coupon_id){

    	//変数の初期値を設定
    	$result = array();

    	//引数がない場合
    	if(is_null($coupon_id) || !is_numeric($coupon_id)){
    		return $result;
    	}

    	//クーポン関連のマスタを取得
    	$msts = $this->Coupons->getModifiedMsts($coupon_id);
    	if(empty($msts)){
    		return $result;
    	}

    	//ユーザー情報を取得
        $user_data = $this->Session->read('Auth');

        //ログインしていない場合
        if(empty($user_data)){
            return $result;
        }

    	//ログ作成に必要な値を格納
        $result['user_id']                  = $user_data['User']['id'];
        $result['company_id']               = $user_data['Company']['id'];
        $result['restaurant_id']            = $msts['restaurants']['id'];
        $result['coupon_id']                = $msts['coupons']['id'];
        $result['set_menus_id']             = $msts['set_menus']['id'];
        $result['set_menus_photos_id']      = $msts['set_menus_photos']['id'];

        return $result;

	}

}