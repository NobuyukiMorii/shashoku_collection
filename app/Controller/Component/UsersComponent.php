<?php
App::uses('Component', 'Controller');

/**
 * ユーザーで利用する関数を集約する
 */
class UsersComponent extends Component {

	//コンポーネントをロード
    public $components = array(
    	'UsersCompaniesLocationsRelations',
    	'UsersCompaniesDepartmentsRelations',
        'UsersCouponsConsumptionsCounts',
    	'Session',
        'Auth'
    );

    /*
     * コントローラーを読み込む
     */
    public function initialize(Controller $controller) {

        $this->Controller = $controller;

    }

    /**
     * クーポンがの認証（消費）情報
     * @return boolean
     */
    public function getThisCouponConsumedInfo($coupon_id){

        //返却値を設定
        $result = array();

        //引数がない場合
        if(is_null($coupon_id) || !is_numeric($coupon_id)){
            return $result;
        }

        //対象のクーポンが本日認証（消費）されたかどうか
        $result['is_authenticated_today']   = $this->checkThisCouponConsumedToday($coupon_id);

        //対象のクーポンが認証（消費）された時間
        $result['authenticated_date']       = $this->getThisCouponConsumedDate($coupon_id);

        return $result;

    }

    /**
     * 対象のクーポンが本日認証（消費）されたかどうか 
     * @return boolean
     */
    public function checkThisCouponConsumedToday($coupon_id){

        $result = false;

        //引数がない場合
        if(is_null($coupon_id) || !is_numeric($coupon_id)){
            return $result;
        }

        //ユーザーが本日クーポンを使ったかどうか
        $is_today_consumed = $this->checkIsUserCouponConsumedToday();
        //本日クーポンを使っていない場合
        if($is_today_consumed === false){
            //引数のクーポンは使っていない
            return $result;
        }

        //以下、本日クーポンを使った場合

        //最後に消費したクーポンidを取得
        $last_consumed_coupon_id = $this->Session->read('Auth.UsersCouponsConsumptionsCount.last_consumed_coupon_id');
        //今月まだクーポンを消費していない場合
        if(is_null($last_consumed_coupon_id)){
            //本日消費していない
            return $result;
        }

        //クーポンidが同じ場合
        if($last_consumed_coupon_id === $coupon_id){
            //引数のクーポンidを本日認証された
            $result = true;
        }

        return $result;

    }

    /**
     * 対象のクーポンが認証（消費）された時間
     * @return boolean
     */
    public function getThisCouponConsumedDate($coupon_id){

        $result = "";

        //引数がない場合
        if(is_null($coupon_id) || !is_numeric($coupon_id)){
            return $result;
        }

        //引数のクーポンが本日認証されたか判定
        $is_authenticated_today = $this->checkThisCouponConsumedToday($coupon_id);
        if($is_authenticated_today === false){
            //本日認証されていないので、空文字を返却
            return $result;
        }

        //クーポンの認証時間を取得
        $authenticated_date = $this->Session->read('Auth.UsersCouponsConsumptionsCount.modified');

        //フォーマットを変更
        $result = date('Y/m/d H:i', strtotime($authenticated_date));

        return $result;
    }

    /**
     * 最終ログインが今月のログインかを判定
     */
    public function checkThisMonthLogin(){

        //返却値を設定
        $result = false;

        //最終ログイン日時を取得
        $last_login_date = $this->Session->read('Auth.last_login_date');

        //最終ログイン日時がない場合
        if(empty($last_login_date)){
            //返却するauthがない可能性があるので、trueとする
            $result = true;
        }

        //今月
        $this_year_month = date('Ym');

        //最終ログイン月
        $last_login_year_month = date('Ym', strtotime($last_login_date));

        //最終ログイン月が今月ではない場合
        if($this_year_month === $last_login_year_month){
            $result = true;
        }

        return $result;

    }

    /**
     * render直前に、ユーザー情報を
     */
    public function setUserDataForView(){

        //現在の月
        $this->Controller->view_data['this_month'] = date('n');

        //ユーザーデータ
        $user_data = $this->Session->read('Auth');

        //ユーザーデータがある場合
        if(!empty($user_data)){

            //ユーザー情報がある場合
            if(!empty($user_data['User'])){

                //ユーザーid
                $this->Controller->view_data['user_data']['user']['id'] = $user_data['User']['id'];

                //ユーザーのemail
                $this->Controller->view_data['user_data']['user']['email'] = $user_data['User']['email'];

            }

            //プロフィール情報がある場合
            if(!empty($user_data['UsersProfile'])){
                //ユーザー名
                $this->Controller->view_data['user_data']['user']['name'] = $user_data['UsersProfile']['family_name'].' '.$user_data['UsersProfile']['first_name'];
            }

            //会社情報がある場合
            if(!empty($user_data['Company'])){
                //会社名
                $this->Controller->view_data['user_data']['company']['name'] = $user_data['Company']['name'];
            }

            //クーポン数情報がある場合  
            if(!empty($user_data['CouponsCount'])){

                //１ヶ月あたりの最大クーポン利用限度枚数
                $this->Controller->view_data['user_data']['user_coupon_status']['count']['monthly'] = $user_data['CouponsCount']['monthly'];

                //現在の利用枚数
                $this->Controller->view_data['user_data']['user_coupon_status']['count']['consumption'] = $user_data['CouponsCount']['consumption'];      

                //残り枚数
                $this->Controller->view_data['user_data']['user_coupon_status']['count']['remaining'] = $user_data['CouponsCount']['remaining'];

                //ユーザーが現在クーポンを利用出来るかどうか
                $this->Controller->view_data['user_data']['user_coupon_status']['availability']['is_available']   = $this->checkIsUserCouponAvailable();

                //ユーザーが今月のクーポンを使い切ったかどうか
                $this->Controller->view_data['user_data']['user_coupon_status']['availability']['less_than_monthly_count'] = $this->checkLessThanMonthlyCount();

                //ユーザーが本日クーポンを利用したかどうか
                $this->Controller->view_data['user_data']['user_coupon_status']['consumed']['today'] = $this->checkIsUserCouponConsumedToday();
            }

        }

    }

    /**
     * ユーザーが現在クーポンを取得出来る状態であるかを判定
     * @return boolean
     */
    public function checkIsUserCouponAvailable(){

        //返却値をしてい
        $result = false;

        //本日利用したかどうか
        $is_consumed_today = $this->checkIsUserCouponConsumedToday();
        if($is_consumed_today === true){
            return $result;
        }

        //今月購入可能か
        $is_month_available = $this->checkLessThanMonthlyCount();
        if($is_month_available === false){
            return $result;
        }

        $result = true;

        return $result;
    }

    /**
     * ユーザーが本日クーポンを使ったかどうかを判定
     * @return boolean
     */
    public function checkIsUserCouponConsumedToday(){

        //返却値を設定（本日クーポンを使っていない）
        $result = false;

        //クーポンの最終利用時間
        $coupon_count_mofidied = $this->Session->read('Auth.UsersCouponsConsumptionsCount.modified');

        //最終利用時間が取得出来ない場合
        if(empty($coupon_count_mofidied)){
            //一度もクーポンを使ったことがないユーザーなので、使っていない
            return $result;
        }

        //更新時間が本日かどうかを確認
        $is_today = DateControl::checkInToday($coupon_count_mofidied);


        //更新日が本日の場合
        if($is_today === true){
            //本日クーポンを使った
            $result = true;
        }

        return $result;

    }

    /**
     * 今月のクーポン利用限度数に達していないことを確認
     * @return array
     */
    public function checkLessThanMonthlyCount(){

        //返却値を設定
        $result = false;

        //ユーザーデータ
        $remaining_count = $this->Session->read('Auth.CouponsCount.remaining');

        //引数がない場合
        if(is_null($remaining_count) || !is_numeric($remaining_count)){
            return $result;
        }

        //残り利用可能数が1以上なら
        if($remaining_count >= 1){
            //クーポン利用限度数に達していない
            $result = true;

        } 

        return $result;

    }

    /**
     * ログイン中のユーザーの情報をSessionに格納
     * @param  int   $user_id
     * @return array
     */
	public function setAuthSession($user_id){

		//返却値を設定
		$result = array();

		//引数がない場合
    	if(is_null($user_id) || !is_numeric($user_id)){
    		return $result;
    	}

    	//ユーザー情報取得
    	$user_data = $this->getUserData($user_id);
    	if(empty($user_data)){
    		return $result;
    	}

        //ユーザー情報にクーポン利用状況を付加
        $user_data = $this->addCouponCountToUserData($user_data);

        //最終ログイン日を付加
        $user_data['last_login_date'] = date('Y-m-d H:i:s');

		//セッションに保存
		$flg = $this->Session->write('Auth', $user_data);

		//成功したら、ユーザーデータを返却値に格納
		if($flg === true){
			return $result = $user_data;
		}

		return $result;

	}
    /**
     * ユーザー情報にクーポン利用状況
     * @param  int   $user_id
     * @return array
     */
    public function addCouponCountToUserData($user_data){
        //返却値を設定
        $result = array();

        //引数がない場合
        if(empty($user_data)){
            return $result;
        }

        //月のクーポン限度数がない場合
        if(is_null($user_data['Company']['monthly_coupon_count'])){
            return $result;
        }

        //今月のクーポン消費枚数がない場合
        if(empty($user_data['UsersCouponsConsumptionsCount']['count'])){
            //0を格納
            $user_data['UsersCouponsConsumptionsCount']['count'] = 0;
        }

        //月のクーポン利用可能枚数
        $user_data['CouponsCount']['monthly'] = intval($user_data['Company']['monthly_coupon_count']);
        unset($user_data['Company']['monthly_coupon_count']);

        //今月のクーポン消費数
        $user_data['CouponsCount']['consumption'] = intval($user_data['UsersCouponsConsumptionsCount']['count']);
        unset($user_data['UsersCouponsConsumptionsCount']['count']);  

        //残りクーポン利用回数
        $user_data['CouponsCount']['remaining']    = $user_data['CouponsCount']['monthly'] - $user_data['CouponsCount']['consumption'];

        return $user_data;

    }

    /**
     * クーポンの利用状況を更新
     * @param  array   $consumption_count 
     * @return array
     */
    public function updateCouponCount($UsersCouponsConsumptionsCount){

        //返却値を設定
        $result = false;

        //引数がない、もしくは配列ではない場合
        if(empty($UsersCouponsConsumptionsCount) || !is_array($UsersCouponsConsumptionsCount)){
            return $result;
        }

        //クーポン利用可能上限数
        $monthly_coupon_count = $this->Session->read('Auth.CouponsCount.monthly');

        //更新後の消費数
        $update_consumption_count = $UsersCouponsConsumptionsCount['count'];

        //更新後の残り利用可能数
        $update_remaining_count = $monthly_coupon_count - $update_consumption_count;

        //重複を除外するために削除
        unset($UsersCouponsConsumptionsCount['count']);

        //クーポン消費数
        $flg['Auth']['CouponsCount']['consumption']    = $this->Session->write('Auth.CouponsCount.consumption', $update_consumption_count);
        //クーポン残り枚数
        $flg['Auth']['CouponsCount']['remaining']      = $this->Session->write('Auth.CouponsCount.remaining', $update_remaining_count);
        //クーポンの消費テーブル
        $flg['Auth']['UsersCouponsConsumptionsCount']  = $this->Session->write('Auth.UsersCouponsConsumptionsCount', $UsersCouponsConsumptionsCount);

        //セッションに正常に保存された場合
        if($flg['Auth']['CouponsCount']['consumption'] === true && $flg['Auth']['CouponsCount']['remaining'] === true && $flg['Auth']['UsersCouponsConsumptionsCount'] === true){
            $result = true;
        }

        return $result;

    }

    /**
     * ユーザーに関連する情報を取得
     * @param  int   $user_id
     * @return array
     */
	public function getUserData($user_id){

		//返却値を設定
		$result = array();

		//引数がない場合
    	if(is_null($user_id) || !is_numeric($user_id)){
    		return $result;
    	}

    	//モデルをロード
		$User 								= ClassRegistry::init('User');
		$UsersProfile 						= ClassRegistry::init('UsersProfile');
		$Company 							= ClassRegistry::init('Company');

		//ユーザー取得
        $result = $this->Auth->user();

        $result['User'] = $User->find('first', array(
            'conditions' => array(
                'id' => $user_id
            ),
            'cache' => true
        ));
        if(empty($result['User'])){
        	return array();
        }

        //プロフィール取得
        $result['UsersProfile'] = $UsersProfile->find('first', array(
            'conditions' => array(
                'user_id' => $user_id
            ),
            'cache' => true
        ));
        if(empty($result['UsersProfile'])){
        	return array();
        }

		//法人取得
        $result['Company'] = $Company->find('first', array(
            'conditions' => array(
                'id' => $result['User']['company_id']
            ),
            'cache' => true
        ));
        if(empty($result['Company'])){
        	return array();
        }

        //部署名取得
        $result['CompaniesDepartment'] = $this->UsersCompaniesDepartmentsRelations->getDepartmentInfo($user_id);
        if(empty($result['CompaniesDepartment'])){
        	return array();
        }

        //所在地取得
        $result['CompaniesLocation'] = $this->UsersCompaniesLocationsRelations->getLocationInfo($user_id);
        if(empty($result['CompaniesLocation'])){
        	return array();
        }

        //クーポン消費枚数取得
        $result['UsersCouponsConsumptionsCount'] = $this->UsersCouponsConsumptionsCounts->getRecord($user_id);
        // *** emptyチェックしない *** //

        return $result;

	}




}