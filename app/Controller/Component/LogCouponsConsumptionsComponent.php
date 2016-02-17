<?php
App::uses('Component', 'Controller');

/**
 * クーポン消費ログに関連利用する関数を集約する
 */
class LogCouponsConsumptionsComponent extends Component {

	//コンポーネントをロード
    public $components = array(
    	'Coupons',
    	'Session',
        'RestaurantsPhotos'
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
        $save_data = $this->getDataForCreate($coupon_id);
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
        $result['user_id']                  = $user_data['User']['id'];
        $result['company_id']               = $user_data['Company']['id'];
        $result['restaurant_id']            = $msts['restaurants']['id'];
        $result['coupon_id']                = $msts['coupons']['id'];
        $result['set_menus_id']             = $msts['set_menus']['id'];
        $result['set_menus_photos_id']      = $msts['set_menus_photos']['id'];

        return $result;

	}

    /**
     * クーポン消費ログ履歴一覧ページ用のデータを取得
     * @param array $user_id
     * @return array 
     */
    public function getDataForHistory($user_id){

        //返却値を設定
        $result = array();

        //引数がない場合
        if(is_null($user_id) || !is_numeric($user_id)){
            return $result;
        }

        //クーポン消費ログの表示に必要なデータを取得
        $data = $this->getLogAndMsts($user_id);
        if(empty($data)){
            return $result;
        }

        //返却値を作成
        $result = $this->makeDataForHistory($data['log_coupons_consumptions'], $data['restaurants'], $data['restaurants_photos'], $data['set_menus'], $data['coupons']);

        return $result;

    }

    /**
     * クーポン消費ログの表示に必要なデータを取得
     * @param array $user_id
     * @return array 
     */
    public function getLogAndMsts($user_id){

        //返却値を設定
        $result = array();

        //引数がない場合
        if(is_null($user_id) || !is_numeric($user_id)){
            return $result;
        }

        //モデルをロード
        $LogCouponsConsumption  = ClassRegistry::init('LogCouponsConsumption');
        $Restaurant             = ClassRegistry::init('Restaurant');
        $Coupons                = ClassRegistry::init('Coupons');
        $SetMenu                = ClassRegistry::init('SetMenu');

        //消費履歴取得
        $log_coupons_consumptions = $LogCouponsConsumption->find('all', array(
            'conditions' => array(
                'user_id' => $user_id
            )
        ));
        if(empty($log_coupons_consumptions)){
            return $result;
        }

        //レストラン取得
        $restaurants = $Restaurant->find('all', array(
            'cache' => true
        ));
        if(empty($restaurants)){
            return $result;
        }

        //レストラン写真取得
        $restaurants_photos = $this->RestaurantsPhotos->getPrimaryPhotos();
        if(empty($restaurants_photos)){
            return $result;
        }

        //クーポン取得
        $coupons = $this->Coupons->getCouponsWithTotalPrice();
        if(empty($coupons)){
            return $result;
        }

        //セットメニュー取得
        $set_menus = $SetMenu->find('all', array(
            'cache' => true
        ));
        if(empty($set_menus)){
            return $result;
        }

        //返却値を作成
        $result['log_coupons_consumptions'] = $log_coupons_consumptions;
        $result['restaurants']              = $restaurants;
        $result['restaurants_photos']       = $restaurants_photos;
        $result['coupons']                  = $coupons;
        $result['set_menus']                = $set_menus;

        return $result;

    }

    /**
     * クーポン消費ログ履歴一覧ページ用のデータを作成
     * @param array $log_coupons_consumptions
     * @param array $restaurants
     * @param array $restaurants_photos
     * @param array $set_menus
     * @param array $coupons
     * @return array 
     */
    public function makeDataForHistory($log_coupons_consumptions, $restaurants, $restaurants_photos, $set_menus, $coupons){

        //返却値を設定
        $result = array();

        //引数がない場合
        if(empty($log_coupons_consumptions) || empty($restaurants) || empty($restaurants_photos) || empty($set_menus) || empty($coupons)){
            return $result;
        }

        //返却値を作成
        foreach ($log_coupons_consumptions as $key => $value) {

            //レストラン格納
            $result[$key]['restaurant']['name']     = $restaurants[$value['restaurant_id']]['name'];
            $result[$key]['restaurant']['address']  = $restaurants[$value['restaurant_id']]['address'];
            $result[$key]['restaurant']['photos']   = IMG_RESTAURANTS_PHOTO.$restaurants_photos[$value['restaurant_id']]['file_name'];
            $result[$key]['set_menu']['name']       = $set_menus[$value['set_menus_id']]['name'];
            $result[$key]['coupon']['price']        = $coupons[$value['coupon_id']]['total_price'];
            $result[$key]['log']['created']         = date('Y/m/d', strtotime($value['created']));

        }

        return $result;

    }

}