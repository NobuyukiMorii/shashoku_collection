<?php
class CouponsController extends AppController {

	//コンポーネントをロード
    public $components = array(
    	'Companies',
        'Coupons',
        'LogCouponsConsumptions',
        'Common'
    );

    /**
     * クーポン表示画面
	 * @param  int   $coupon_id
	 * @return array
     */
    public function show($coupon_id=null) {

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

        //ログ保存
        $log_data = $this->LogCouponsConsumptions->createLog($coupon_id);

        //ログ保存に失敗した場合
        if($log_data === false){

            $this->Common->returnError(Configure::read('ERR_CODE_FAIL_SAVE'), __('クーポン利用履歴を保存出来ませんでした。'));   
               return;
        }

    }

    /**
     * クーポン消費履歴確認画面
     * @return array
     */
    public function history() {

        //ユーザーidを取得
        $user_id = $this->Auth->user('id');
        if(empty($user_id)){

            $this->Common->returnError(Configure::read('ERR_CODE_NOT_LOGIN'), __('ログインしていません。'));   
            return;
        }

        //消費履歴を取得
        $this->loadModel('LogCouponsConsumption');

        $this->view_data['logs'] = $this->LogCouponsConsumption->find('all', array(
            'conditions' => array(
                'user_id' => $user_id
            )
        ));

    }

}