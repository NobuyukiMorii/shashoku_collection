<?php
class CouponsController extends AppController {

	//コンポーネントをロード
    public $components = array(
        'Users',
        'Coupons',
        'LogCouponsConsumptions',
        'Common',
        'Session',
        'LogCouponsDisplays'
    );

    /**
     * クーポン表示画面
	 * @param  int      $coupon_id
     * @param  boolean  $coupons_consumption
	 * @return array
     */
    public function show($coupon_id=null, $is_coupons_consumption=null) {

        //----------------------------------------
        //引数取得
        //----------------------------------------
        //クーポンidを取得
        if(empty($coupon_id)){
    		$coupon_id = Arguments::getArguments('coupon_id');
    	}
        //クーポン消費フラグを取得
        if(empty($is_coupons_consumption)){
            $is_coupons_consumption = Arguments::getArguments('is_coupons_consumption');
        }
        //----------------------------------------
        //引数のチェック
        //----------------------------------------
    	//クーポンidが設定されなかった場合
    	if(is_null($coupon_id) || !is_numeric($coupon_id)){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_PARAM'), __('対象のクーポンが取得出来ません。'));	
			return;
    	}
        //----------------------------------------
        //クーポン取得
        //----------------------------------------
		$this->view_data['coupon'] = $this->Coupons->getOneCouponForDisp($coupon_id);

        //----------------------------------------
        //クーポン表示履歴保存
        //----------------------------------------
        $save_log_display = $this->LogCouponsDisplays->createLog($coupon_id, $is_coupons_consumption);
        if(empty($save_log_display)){
            $this->Common->returnError(Configure::read('ERR_CODE_FAIL_SAVE'), __('クーポン表示履歴を保存出来ませんでした。'));   
            return;    
        }

        //----------------------------------------
        //クーポン認証（消費）
        //----------------------------------------
        //クーポンを認証（消費）する場合
        if(isset($is_coupons_consumption) && $is_coupons_consumption === true){

            //----------------------------------------
            //クーポンが利用出来るかどうかを判定（クーポン月内利用可能残り枚数判定・本日利用済み判定）
            //----------------------------------------
            $is_available = $this->Users->checkIsUserCouponAvailable();
            //現在、ユーザーがクーポンが利用出来ない場合（本来はフロント側でアクセスを制限しているはず。）
            if($is_available === false){
                $this->Common->returnError(Configure::read('ERR_CODE_ILLEGAL_ACCESS'), __('現在、クーポンは利用出来ません。'));   
                return;  
            }

            //----------------------------------------
            //クーポン認証（消費）ログ保存
            //----------------------------------------
            $save_log_consumption = $this->Coupons->saveLogAndUserData($coupon_id);
            if(empty($save_log_consumption)){
                $this->Common->returnError(Configure::read('ERR_CODE_FAIL_SAVE'), __('クーポン認証履歴を保存出来ませんでした。'));   
                return;
            }

            //----------------------------------------
            //クーポン認証フラグを変更する
            //----------------------------------------
            $this->view_data['coupon']['coupon']['is_authenticated_today'] = true;

        }

        return $this->view_data;

    }

    /**
     * クーポン認証（消費）履歴確認画面
     * @param  int   $page  beforeFilterにて取得
     * @return array
     */
    public function history() {

        //----------------------------------------
        //ページングを利用
        //----------------------------------------
        $this->paging['is_use'] = true;

        //----------------------------------------
        //クーポン認証（消費）履歴を取得
        //----------------------------------------
        $this->view_data['logs'] = $this->LogCouponsConsumptions->getDataForHistory();

        return $this->view_data;

    }

}