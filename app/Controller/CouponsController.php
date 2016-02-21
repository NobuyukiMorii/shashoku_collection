<?php
class CouponsController extends AppController {


	//コンポーネントをロード
    public $components = array(
        'Users',
        'Coupons',
        'LogCouponsConsumptions',
        'UsersCouponsConsumptionsCounts',
        'Common',
        'Session'
    );

    /**
     * クーポン表示画面
	 * @param  int   $coupon_id
     * @param  bool  $coupons_consumption
	 * @return array
     */
    public function show($coupon_id=null, $is_coupons_consumption=null) {

        //クーポンidを取得
        if(empty($coupon_id)){
    		$coupon_id = Arguments::getArguments('coupon_id');
    	}
        //クーポン消費フラグを取得
        if(empty($is_coupons_consumption)){
            $is_coupons_consumption = Arguments::getArguments('is_coupons_consumption');
        }
    	//クーポンidが設定されなかった場合
    	if(is_null($coupon_id) || !is_numeric($coupon_id)){

			$this->Common->returnError(Configure::read('ERR_CODE_NO_PARAM'), __('対象のクーポンが取得出来ません。'));	
			return;
    	}

    	//クーポン情報を取得
		$this->view_data['coupon']  = $this->Coupons->getOneCouponForDisp($coupon_id);

        //クーポンを消費する場合
        if(isset($is_coupons_consumption) && $is_coupons_consumption === true){

            //クーポンが利用出来るかどうかを判定
            $is_available = $this->Users->checkIsUserCouponAvailable();
            //不可能の場合
            if($is_available === false){

                $this->Common->returnError(Configure::read('ERR_CODE_ILLEGAL_ACCESS'), __('現在、クーポンは利用出来ません。'));   
                return;  
            }
            //ログと消費枚数を保存
            $save_data = $this->Coupons->saveLogAndUserData($coupon_id);
            if(empty($save_data)){

                $this->Common->returnError(Configure::read('ERR_CODE_FAIL_SAVE'), __('クーポン利用履歴を保存出来ませんでした。'));   
                return;
            }

        }

    }

    /**
     * クーポン消費履歴確認画面
     * @return array
     */
    public function history() {

        //ページを利用
        $this->paging['is_use'] = true;

        //ログを取得
        $this->view_data['logs'] = $this->LogCouponsConsumptions->getDataForHistory();

    }

}