<?php
App::uses('Component', 'Controller');

/**
 * クーポン表示ログに関連利用する関数を集約する
 */
class LogCouponsDisplaysComponent extends Component {

	//コンポーネントをロード
    public $components = array(
    	'Coupons',
    	'LogCoupons',
    	'LogCouponsConsumptions',
    	'Users'
    );

    /**
     * コントローラーを読み込む
     */
    public function initialize(Controller $controller) {

        $this->Controller = $controller;

    }

    /**
     * クーポン表示ログに必要なデータを取得
     * @param int   $coupon_id
     * @return array 
     */
	public function createLog($coupon_id, $is_coupons_consumption=null){

		//返却値を設定
		$result = array();

		//返却値を設定
		if(empty($coupon_id) || !is_numeric($coupon_id)){
			return $result;
		}

    	//保存する情報を取得
    	$save_data = $this->LogCoupons->getDataForCreate($coupon_id);
    	if(empty($save_data)){
    		return $result;
    	}

    	//認証フラグを格納
    	$save_data['authenticated_status_flg'] = $this->getAuthenticatedFlg($coupon_id, $is_coupons_consumption);

        //モデルをロード
        $LogCouponsDisplay  = ClassRegistry::init('LogCouponsDisplay');

        //saveを指定（updateではない）
        $LogCouponsDisplay->create();

        //クーポン消費ログを保存
        $result = $LogCouponsDisplay->save($save_data);

        return $result;

	}

    /**
     * クーポン認証フラグ
     * @param  int      $coupon_id
     * @param  boolean  $is_coupons_consumption
     * @return array 
     */
	public function getAuthenticatedFlg($coupon_id, $is_coupons_consumption=null){

		//返却値を設定
		$result = Configure::read('COUPON_AUTHONICATED_STATUS_NOT_AUTHONICATED');;

		//返却値を設定
		if(empty($coupon_id) || !is_numeric($coupon_id)){
			return $result;
		}

		//本日引数のクーポンを認証済みかどうか
		$is_this_coupon_consumed_today = $this->Users->checkThisCouponConsumedToday($coupon_id);
		if($is_this_coupon_consumed_today === true){
			$result = Configure::read('COUPON_AUTHONICATED_STATUS_CONSUME_THIS_COUPON_TODAY');
			return $result;		
		}

		//本日他のクーポンを認証済みかどうか
		$is_user_coupon_consumed_today = $this->Users->checkIsUserCouponConsumedToday();
		if($is_user_coupon_consumed_today === true){
			$result = Configure::read('COUPON_AUTHONICATED_STATUS_CONSUME_OTHER_COUPON_TODAY');
			return $result;		
		}

    	//今月の利用限度数より少ないかどうか
		$is_less_than_monthly_count = $this->Users->checkLessThanMonthlyCount();
		if($is_less_than_monthly_count === false){
			$result = Configure::read('COUPON_AUTHONICATED_STATUS_MORE_THAN_MONTHLY_COUNT');
			return $result;	
		}

		//認証されるタイミングかどうか
		if(isset($is_coupons_consumption) && $is_coupons_consumption === true){
			$result = Configure::read('COUPON_AUTHONICATED_STATUS_NOW_AUTHONICATED');
			return $result;	
		}

		return $result;

	}

}