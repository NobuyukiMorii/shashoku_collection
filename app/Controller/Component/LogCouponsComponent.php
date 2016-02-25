<?php
App::uses('Component', 'Controller');

/**
 * クーポン消費ログに関連利用する関数を集約する
 */
class LogCouponsComponent extends Component {

	//コンポーネントをロード
    public $components = array(
    	'Coupons',
    	'Session'
    );

    /**
     * クーポン消費ログに必要なデータを取得
     * @param  int   $coupon_id
     * @return array 
     */
	public function getDataForCreate($coupon_id){

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
        $result['user_id']                      = $user_data['User']['id'];
        $result['users_profile_id']             = $user_data['UsersProfile']['id'];
        $result['family_name']                  = $user_data['UsersProfile']['family_name'];
        $result['first_name']                   = $user_data['UsersProfile']['first_name'];
        $result['company_id']                   = $user_data['Company']['id'];
        $result['department_id']                = $user_data['CompaniesDepartment'][0]['id'];
        $result['department_name']              = $user_data['CompaniesDepartment'][0]['name'];
        $result['department_ids']               = ArrayControl::getCommaSeparatedValue($user_data['CompaniesDepartment'], 'id');
        $result['location_id']                  = $user_data['CompaniesLocation'][0]['id'];
        $result['location_name']                = $user_data['CompaniesLocation'][0]['name'];
        $result['location_ids']                 = ArrayControl::getCommaSeparatedValue($user_data['CompaniesLocation'], 'id');
        $result['restaurant_id']                = $msts['restaurants']['id'];
        $result['restaurant_name']              = $msts['restaurants']['name'];
        $result['restaurants_photo_file_name']  = $msts['restaurants_photos']['file_name'];
        $result['restaurants_photo_ids']        = $msts['restaurants_photo_ids'];
        $result['restaurants_genre_ids']        = $msts['restaurants_genre_ids'];
        $result['restaurants_tag_ids']          = $msts['restaurants_tag_ids'];
        $result['coupon_id']                    = $msts['coupons']['id'];
        $result['total_price']                  = $msts['coupons']['total_price'];
        $result['additional_price']             = $msts['coupons']['additional_price'];
        $result['basic_price']                  = $user_data['Company']['basic_price'];
        $result['set_menu_id']                  = $msts['set_menus']['id'];
        $result['set_menu_name']                = $msts['set_menus']['name'];
        $result['set_menus_photo_file_name']    = $msts['set_menus_photos']['file_name'];
        $result['set_menus_photo_id']           = $msts['set_menus_photos']['id'];
        $result['set_menus_photo_ids']          = $msts['set_menus_photo_ids'];
        $result['yearmonth']                    = intval(date('Ym'));

        return $result;

	}

}