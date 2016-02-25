<?php
App::uses('Component', 'Controller');

/**
 * クーポン消費ログに関連利用する関数を集約する
 */
class LogCouponsConsumptionsComponent extends Component {

	//コンポーネントをロード
    public $components = array(
    	'Coupons',
        'LogCoupons',
    	'Session',
        'RestaurantsPhotos'
    );

    /**
     * コントローラーを読み込む
     */
    public function initialize(Controller $controller) {

        $this->Controller = $controller;

    }

    //----------------------------------------
    //ログ生成関連
    //----------------------------------------
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
        $save_data = $this->LogCoupons->getDataForCreate($coupon_id);
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

    //----------------------------------------
    //ログ表示関連
    //----------------------------------------
    /**
     * クーポン消費ログ履歴一覧ページ用のデータを取得
     * @return array 
     */
    public function getDataForHistory(){

        //返却値を設定
        $result = array();

        //クーポン消費ログの表示に必要なデータを取得
        $data = $this->getLogAndMsts();
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
    public function getLogAndMsts(){

        //返却値を設定
        $result = array();

        //ユーザーidを取得
        $user_id        = $this->Session->read('Auth.User.id');
        //法人idを取得
        $company_id     = $this->Session->read('Auth.Company.id');

        //ユーザーidか法人idがない場合
        if(is_null($user_id) || is_null($company_id)){
            return $result;
        }

        //モデルをロード
        $LogCouponsConsumption  = ClassRegistry::init('LogCouponsConsumption');
        $Restaurant             = ClassRegistry::init('Restaurant');
        $Coupons                = ClassRegistry::init('Coupons');
        $SetMenu                = ClassRegistry::init('SetMenu');

        //総レコード数（countにはdel_flg除去が組み込まれていないため、del_flgをコンディションに追加）
        $total_records = $LogCouponsConsumption->find('count', array(
            'conditions' => array(
                'company_id' => $company_id,
                'user_id' => $user_id,
                'del_flg' => Configure::read('RECORD_NOT_DELETED')
            )
        ));

        //総ページ数
        $this->Controller->paging['total_pages'] = ceil($total_records/$this->Controller->paging['limit_per_page']);

        //消費履歴取得
        $log_coupons_consumptions = $LogCouponsConsumption->find('all', array(
            'conditions' => array(
                'company_id' => $company_id,
                'user_id' => $user_id
            ),
            'page'  => $this->Controller->paging['current_page'],
            'limit' => $this->Controller->paging['limit_per_page'],
            'order' => array('LogCouponsConsumption.created DESC'), 
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
        $flg = ArrayControl::multipleEmptyCheck($log_coupons_consumptions, $restaurants, $restaurants_photos, $set_menus, $coupons);
        if($flg === false){
            return $result;
        }

        //返却値を作成
        foreach ($log_coupons_consumptions as $key => $value) {

            //返却用配列を作成
            $result[$value['yearmonth']][] = array();

            //追加したキーを取得
            $new_key = ArrayControl::endKey($result[$value['yearmonth']]);

            //返却値を格納
            //レストランidを格納
            $result[$value['yearmonth']][$new_key]['restaurant']['id']       = $value['restaurant_id'];
            //レストランの名（名前が変更になった場合、反映される。）
            $result[$value['yearmonth']][$new_key]['restaurant']['name']     = $restaurants[$value['restaurant_id']]['name'];
            //レストラン住所（住所が変更になった場合は、反映される。）
            $result[$value['yearmonth']][$new_key]['restaurant']['address']  = $restaurants[$value['restaurant_id']]['address'];
            //セットメニュー写真（写真が変更になった場合は、反映される。）
            $result[$value['yearmonth']][$new_key]['restaurant']['photos']   = IMG_RESTAURANTS_PHOTO.$restaurants_photos[$value['restaurant_id']]['file_name'];
            //セットメニュー名（メニュー名が変更になった場合は、反映される。）
            $result[$value['yearmonth']][$new_key]['set_menu']['name']       = $set_menus[$value['set_menu_id']]['name'];
            //価格のみログの情報を利用する（クーポンの価格変更、及び、法人の基礎料金の変更に左右されない。）
            $result[$value['yearmonth']][$new_key]['coupon']['price']        = $value['total_price'];
            //クーポン発行日時
            $result[$value['yearmonth']][$new_key]['log']['created']         = date('Y/m/d', strtotime($value['created']));

        }

        //年月を新しい順にソート
        krsort($result);

        return $result;

    }

}