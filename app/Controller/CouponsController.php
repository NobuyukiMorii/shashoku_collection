<?php
class CouponsController extends AppController {

	//コンポーネントをロード
    public $components = array(
    	'Companies',
        'Coupons',
        'Common'
    );

    /*
     * クーポン表示画面
	 * @param  int   $restaurant_id
	 * @return array
     */
    public function show($coupon_id=null) {

        //----------------------------------------
        //法人id取得。ログイン機能実装後、本コードは削除する。自動的に取得出来るように修正する。
        //----------------------------------------
		$company_id = 1;

        //会社情報をappコントローラーのメンバ変数に格納
		$this->user_data['company'] = $this->Companies->getCompanyById($company_id);

        //----------------------------------------
        //クーポンidを取得
        //----------------------------------------
        if(empty($coupon_id)){
    		$coupon_id = Arguments::getArguments('coupon_id');
    	}
    	//クーポンidが設定されなかった場合
    	if(is_null($coupon_id) || !is_numeric($coupon_id)){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_PARAM'), __('対象のクーポンが取得出来ません。'));	
			return;
    	}

    	//クーポン情報を取得
		$this->view_data['coupon']  = $this->Coupons->getOneCouponForDisp($coupon_id);

		//現在の時刻を格納
		$this->view_data['now']  	= date('Y/m/d H:i');









    	var_dump($this->view_data);
    	exit;




    }

    public function history() {

    }

}