<?php
App::uses('Component', 'Controller');

/**
 * クーポン関連で利用する関数を集約する
 */
class CouponsComponent extends Component {

	//コンポーネントをロード
    public $components = array(
        'Users',
    	'SetMenus',
        'LogCouponsConsumptions',
        'UsersCouponsConsumptionsCounts',
        'Session',
        'Transactions'
    );

    /*
     * コントローラーを読み込む
     */
    public function initialize(Controller $controller) {

      $this->Controller = $controller;

    }

    //----------------------------------------
    //クーポン表示関連
    //CouponsController::show
    //----------------------------------------

	/**
	 * 表示用のクーポンを取得する
     * CouponsController::show
	 * @param array $coupon_id
	 * @return array
	 */
    public function getOneCouponForDisp($coupon_id){

    	//変数の初期値を設定
    	$result = array();

    	//引数がない場合
    	if(is_null($coupon_id) || !is_numeric($coupon_id)){
    		return $result;
    	}

    	//クーポン関連情報を取得
    	$msts = $this->getModifiedMsts($coupon_id);
    	if(empty($msts)){
    		return $result;
    	}

        //レストラン名
        $result['restaurant']['id']                 = $msts['restaurants']['id'];
    	//レストラン名
    	$result['restaurant']['name'] 				= $msts['restaurants']['name'];
        //表示するクーポンが本日認証済みかどうか
        $result['coupon']['is_authenticated_today'] = $this->Users->checkThisCouponConsumedToday($coupon_id);
    	//クーポンの追加料金
    	$result['coupon']['additional_price'] 		= $msts['coupons']['additional_price'];
    	//クーポンの価格
    	$result['coupon']['price'] 					= $this->getTotalPrice($msts['coupons']['additional_price']);
    	//セットメニューの写真
    	$result['coupon']['set_menu']['photo_url'] 	= IMG_SET_MENUS_PHOTO.$msts['set_menus_photos']['file_name'];
    	//料理名
    	$result['coupon']['set_menu']['name'] 		= $msts['set_menus']['name'];
        //現在の時刻
        $result['date_time']                        = $this->getDateTimeForDisp($coupon_id);

    	return $result;

    }

    /**
     * CouponsComponent::getMsts（クーポン関連の情報を取得する関数）の返却値（マスタの配列）を使いやすいように修正
     * 1)Coupons::getOneCouponForDisp
     * 2)LogCoupons::getDataForCreate
     * @param  int    $coupon_id
     * @return array
     */
    public function getModifiedMsts($coupon_id){

        //変数の初期値を設定
        $result = array();

        //引数がない場合
        if(is_null($coupon_id) || !is_numeric($coupon_id)){
            return $result;
        }

        //マスタ取得
        $msts = $this->getMsts($coupon_id);
        if(empty($msts)){
            return $result;
        }

        //合計額を取得
        $msts['coupons']['total_price'] = $this->getTotalPrice($msts['coupons']['additional_price']);

        //レストラン写真idをカンマ区切りで取得
        $msts['restaurants_photo_ids'] = ArrayControl::getCommaSeparatedValue($msts['restaurants_photos'], 'id');

        //セットメニュー写真idをカンマ区切りで取得
        $msts['set_menus_photo_ids'] = ArrayControl::getCommaSeparatedValue($msts['set_menus_photos'], 'id');

        //レストランジャンルidをカンマ区切りで取得
        $msts['restaurants_genre_ids'] = ArrayControl::getCommaSeparatedValue($msts['restaurants_genres_relations'], 'restaurants_genre_id');

        //レストランタグidをカンマ区切りで取得
        $msts['restaurants_tag_ids'] = ArrayControl::getCommaSeparatedValue($msts['restaurants_tags_relations'], 'restaurants_tag_id');

        //優先順位の最も高いレストランの写真を取得
        $RestaurantsPhoto  = ClassRegistry::init('RestaurantsPhoto');
        $msts['restaurants_photos']                   = $RestaurantsPhoto->getPrimaryRecord($msts['restaurants_photos']);
        if(empty($msts['restaurants_photos'])){
            return $result;
        }

        //優先順位の最も高いセットメニューの写真を取得
        $SetMenusPhoto  = ClassRegistry::init('SetMenusPhoto');
        $msts['set_menus_photos']                   = $SetMenusPhoto->getPrimaryRecord($msts['set_menus_photos']);
        if(empty($msts['set_menus_photos'])){
            return $result;
        }

        //返却値にマスタ情報を格納
        $result = $msts;

        return $result;

    }

    /**
     * クーポン関連のマスタを取得
     * CouponsComponent::getModifiedMstsで利用
     * @param 　int    $coupon_id
     * @return array
     */
    public function getMsts($coupon_id){

        //変数の初期値を設定
        $result = array();

        //引数がない場合
        if(is_null($coupon_id) || !is_numeric($coupon_id)){
            return $result;
        }

        //モデルをロード
        $Coupon                         = ClassRegistry::init('Coupon');
        $SetMenu                        = ClassRegistry::init('SetMenu');
        $SetMenusPhoto                  = ClassRegistry::init('SetMenusPhoto');
        $Restaurant                     = ClassRegistry::init('Restaurant');
        $RestaurantsPhoto               = ClassRegistry::init('RestaurantsPhoto');
        $RestaurantsGenresRelation      = ClassRegistry::init('RestaurantsGenresRelation');
        $RestaurantsTagsRelation        = ClassRegistry::init('RestaurantsTagsRelation');

        //クーポン取得
        $coupons = $Coupon->find('first', array(
            'conditions' => array(
                'id' => $coupon_id
            ),
            'cache' => true
        ));
        if(empty($coupons)){
            return $result;
        }

        //セットメニュー取得
        $set_menus = $SetMenu->find('first', array(
            'conditions' => array(
                'id' => $coupons['set_menu_id']
            ),
            'cache' => true
        ));
        if(empty($set_menus)){
            return $result;
        }

        //セットメニュー写真取得
        $set_menus_photos = $SetMenusPhoto->find('all', array(
            'conditions' => array(
                'id' => $coupons['set_menu_id']
            ),
            'cache' => true
        ));
        if(empty($set_menus_photos)){
            return $result;
        }

        //レストラン取得
        $restaurants = $Restaurant->find('first', array(
            'conditions' => array(
                'id' => $coupons['restaurant_id']
            ),
            'cache' => true
        ));
        if(empty($restaurants)){
            return $result;
        }

        //レストランジャンル関連性取得
        $restaurants_genres_relations = $RestaurantsGenresRelation->find('all', array(
            'conditions' => array(
                'restaurant_id' => $coupons['restaurant_id']
            ),
            'cache' => true
        ));
        if(empty($restaurants_genres_relations)){
            return $result;
        }

        //レストランタグ関連性取得
        $restaurants_tags_relations = $RestaurantsTagsRelation->find('all', array(
            'conditions' => array(
                'restaurant_id' => $coupons['restaurant_id']
            ),
            'cache' => true
        ));
        if(empty($restaurants_tags_relations)){
            return $result;
        }

        //レストラン写真取得
        $restaurants_photos = $RestaurantsPhoto->find('all', array(
            'conditions' => array(
                'restaurant_id' => $coupons['restaurant_id']
            ),
            'cache' => true
        ));
        if(empty($restaurants_photos)){
            return $result;
        }        

        //返却値を作成
        $result['coupons']                             = $coupons;
        $result['set_menus']                           = $set_menus;
        $result['set_menus_photos']                    = $set_menus_photos;
        $result['restaurants']                         = $restaurants;
        $result['restaurants_genres_relations']        = $restaurants_genres_relations;
        $result['restaurants_tags_relations']          = $restaurants_tags_relations;
        $result['restaurants_photos']                  = $restaurants_photos;

        return $result;

    }

    /**
     * CouponsComponent::getOneCouponForDisp（クーポン関連の情報を取得する関数）のdate_timeを取得
     * CouponsComponent::getOneCouponForDisp
     * @param array $coupon_id
     * @return array
     */
    public function getDateTimeForDisp($coupon_id){

        //変数の初期値を設定
        $result = array();

        //引数がない場合
        if(is_null($coupon_id) || !is_numeric($coupon_id)){
            return $result;
        }

        //対象のクーポンが本日認証（消費）されたかどうか 
        $authentication_info = $this->Users->getThisCouponConsumedInfo($coupon_id);

        //本日既に認証されていた場合
        if($authentication_info['is_authenticated_today'] === true){
            //認証された時間
            $result = date('Y/m/d H:i', strtotime($authentication_info['authenticated_date']));
        } else {
            //現ジアの時間
            $result = date('Y/m/d H:i');
        }

        return $result;

    }

    //----------------------------------------
    //クーポン履歴保存関連
    //CouponsController::show
    //----------------------------------------
    /**
     * ログとユーザーデータを保存する
     * CouponsController::show
     * @param  array $coupon_id
     * @return array
     */
    public function saveLogAndUserData($coupon_id){

        //変数の初期値を設定
        $result = array();

        //引数がない場合
        if(is_null($coupon_id) || !is_numeric($coupon_id)){
            return $result;
        }

        //モデルをロード
        $TransactionManager                         = ClassRegistry::init('TransactionManager');

        //トランザクション開始
        $transaction = $this->Transactions->start(__FUNCTION__);
        
        //トランザクション開始に失敗した場合
        if(empty($transaction)){
            return $result;
        }

        try{
            
            //消費ログ保存
            $log_data = $this->LogCouponsConsumptions->createLog($coupon_id);

            //ユーザーのクーポン消費枚数をupdate
            $user_coupons_count = $this->UsersCouponsConsumptionsCounts->createRecord($coupon_id);

            //成功時
            if(!empty($log_data) || !empty($user_coupons_count)){

                //更新前のAuthをread
                $old_user_data = $this->Session->read('Auth');

                //セッションのクーポン使用状況を更新
                $flg = $this->Users->updateCouponCount($user_coupons_count['UsersCouponsConsumptionsCount']);

                //セッション更新成功時
                if($flg === true){

                    //コミット
                    $this->Transactions->end(true, $transaction, __FUNCTION__);

                } else {
                //セッション更新失敗時

                    //ロールバック
                    $this->Transactions->end(false, $transaction, __FUNCTION__);

                    //Authセッションを巻き戻す
                    $this->Session->write('Auth', $old_user_data);

                    return $result;

                }

            } else {

            //失敗時
                //ロールバック
                $this->Transactions->end(false, $transaction, __FUNCTION__);

                return $result;

            }

        } catch(Exception $e) {

        //失敗時
            //ロールバック
            $this->Transactions->end(false, $transaction, __FUNCTION__);

            return $result;

        }

        //返却値を格納
        $result = array_merge($log_data, $user_coupons_count);

        return $result;

    }

    //----------------------------------------
    //レストランへのクーポン付加
    //RestaurantsComponent
    //----------------------------------------
	/**
	 * １つのレストランに複数のクーポン情報を追加する
     * RestaurantsComponent::getRestaurantById
	 * @param array $restaurant
	 * @return array
	 */
    public function AddCouponsInfoToRestaurant($restaurant){

    	//引数をチェック
    	if(empty($restaurant)){
    		return array();
    	}

    	//モデルをロード
		$Coupon 		= ClassRegistry::init('Coupon');
		$SetMenu 		= ClassRegistry::init('SetMenu');
		$SetMenusPhoto 	= ClassRegistry::init('SetMenusPhoto');

		//クーポンを取得
		$coupons = $Coupon->find('all', array(
			'conditions' => array(
				'restaurant_id' => $restaurant['id']
			),
			'cache' => true
		));
		if(empty($coupons)){
			return array();
		}

		//期間外のクーポンを除去
		$coupons = $Coupon->extractRecordInPeriod($coupons);

		//セットメニューのidを取得
		$set_menu_ids = Hash::extract($coupons, '{n}.set_menu_id');

		//クーポンをpriority_order順に並べ替える
		$coupons = Hash::sort($coupons, '{n}.priority_order');

		//クーポンのキーをidとする
		$coupons = Hash::combine($coupons, '{n}.id', '{n}');

		//セットメニュー（写真付き）を取得
		$set_menus = $this->SetMenus->getSetMenuWitPhoto($set_menu_ids);
		if(empty($set_menus)){
			return array();
		}

		//セットメニューのキーをidとする
		$set_menus = Hash::combine($set_menus, '{n}.id', '{n}');

		//クーポンをループ
		foreach ($coupons as $key => $value) {

			/* クーポンとセットメニューを結合 */
			//クーポンの対象のセットメニューがあれば
			if(!empty($set_menus[$value['set_menu_id']])){

				//セットメニュー名を追加
				$coupons[$key]['set_menu']['name'] 				= $set_menus[$value['set_menu_id']]['name'];

				//セットメニューの説明文を追加
				$coupons[$key]['set_menu']['description'] 		= $set_menus[$value['set_menu_id']]['description'];			

				//写真を追加
				$coupons[$key]['set_menu']['photo_url'] 		= $set_menus[$value['set_menu_id']]['photo_url'];

			}

			/* 追加料金と基礎料金を合算 */
			$coupons[$key]['price'] = $this->getTotalPrice($value['additional_price']);

		}

		//クーポンから不必要なキーと値を除去
		$coupons = ArrayControl::removeKeys($coupons, array('restaurant_id', 'priority_order', 'set_menu_id', 'created', 'modified'));

		//新たな配列を作成
		$restaurant['coupons'] = array();

		//レストランにクーポンの数量を格納
		$restaurant['coupons']['count'] = count($coupons);

		//レストランにメニューの情報を追加
		$restaurant['coupons']['list'] = $coupons;

		//返却
		return $restaurant;

    }

	/**
	 * レストランの配列にクーポン情報を追加する
     * RestaurantsComponent::ApplyMstsToRestaurants
	 * @param array $restaurants
	 * @param array $coupons
	 * @param array $set_menus
	 * @return array
	 */
    public function AddCouponInfoToRestaurants($restaurants, $coupons, $set_menus){

    	//引数をチェック
    	$flg = ArrayControl::multipleEmptyCheck($restaurants, $coupons, $set_menus);
    	if($flg === false){
    		return array();
    	}

		/* レストランにクーポンの数量を追加する */
		$restaurants = $this->AddCouponCountToRestaurants($restaurants, $coupons);
		if(empty($restaurants)){
			return array();
		}

		/* レストランに優先順位の一番高いクーポンを追加する */
		$restaurants = $this->AddPrimaryCouponInfoToRestaurants($restaurants, $coupons, $set_menus);

		return $restaurants;

    }

	/**
	 * それぞれのレストランにクーポンの数量を追加する
	 * @param array $restaurants
	 * @param array $coupons
	 * @return array
	 */
    public function AddCouponCountToRestaurants($restaurants, $coupons){

    	//引数をチェック
    	$flg = ArrayControl::multipleEmptyCheck($restaurants, $coupons);
    	if($flg === false){
    		return array();
    	}

    	/* レストランidごとのクーポンの数量を取得する */
    	$coupons_count = ArrayControl::getCountOfValueOfTargetKey($coupons, 'restaurant_id');
    	if(empty($coupons_count)){
    		return array();
    	}

    	/* レストランに数量を格納するキーを設定する。*/
    	$restaurants_key_for_coupons_count = 'coupons.count';

    	/* レストランにクーポンの数量を追加する（$restaurants[n][coupons][count]の形式でクーポンの数量を格納） */
    	$restaurants = ArrayControl::arrayMergeToTargetKey($restaurants, $coupons_count, $restaurants_key_for_coupons_count);

    	return $restaurants;

    }

	/**
	 * それぞれのレストランにクーポンを追加する
	 * （優先順位が最も高いクーポンのみ）
	 * @param array $restaurants
	 * @param array $coupons
	 * @param array $set_menus
	 * @return array
	 */
    public function AddPrimaryCouponInfoToRestaurants($restaurants, $coupons, $set_menus){
	
		//レストランごとに、優先順位の高いクーポンを取得する
		$Coupon = ClassRegistry::init('Coupon');
		$primary_coupons = $Coupon->getPrimaryRecordOfEachKey($coupons, 'restaurant_id');

        /* クーポンの情報を$restaurantsの配列内に追加する */
    	foreach ($primary_coupons as $key => $value) {

    		//クーポンの対象のレストランが存在する場合
    		if(!empty($restaurants[$value['restaurant_id']])) {

	    		//クーポンの価格を追加する
	    		$restaurants[$value['restaurant_id']]['coupons']['price'] = $this->getTotalPrice($value['additional_price']);

	    		//セットメニューの名前を追加する
	    		if(!empty($set_menus[$value['set_menu_id']]['name'])){

	    			$restaurants[$value['restaurant_id']]['coupons']['set_menu_name']	= $set_menus[$value['set_menu_id']]['name'];

	    		}

	    	}

    	}

    	return $restaurants;

    }

    //----------------------------------------
    //クーポンの料金計算
    //RestaurantsComponent
    //----------------------------------------
    /**
     * クーポンを合計料金と合わせて取得
     * @return array
     */
    public function getCouponsWithTotalPrice(){

        //返却値を設定
        $result =  array();

        //モデルをロード
        $Coupon         = ClassRegistry::init('Coupon');

        //クーポン取得
        $coupons = $Coupon->find('all', array(
            'cache' => true
        ));
        if(empty($coupons)){
            return $coupons;
        }

        //合計金額を追加
        foreach ($coupons as $key => $value) {
            $result[$key]                   = $value;
            $result[$key]['total_price']    = $this->getTotalPrice($value['additional_price']);
        }

        return $result;

    }

	/**
	 * 基本料金を取得する
	 * @return array
	 */
    public function getBasicPrice(){

    	//返却値を設定
    	$result = 0;

        //セッションからUser_dataを取得
        $user_data = $this->Session->read('Auth');
        if(empty($user_data)){
            return $result;
        }

        //結果を格納
        $result = $user_data['Company']['basic_price'];

		return $result;

    }

	/**
	 * 基礎料金(basic_price)と追加料金（additional_price）の合計額を取得する
	 * @param array $coupon_id
	 * @return array
	 */
    public function getTotalPrice($additional_price){

    	//返却値を設定
    	$result = 0;

    	//基本料金がない場合
    	if(is_null($additional_price) || !is_numeric($additional_price)){
    		return $result;
    	}

    	//基礎料金を取得
    	$basic_price = $this->getBasicPrice();

    	//合計料金を取得
    	$result = $basic_price + $additional_price;

    	return $result;
    }

}