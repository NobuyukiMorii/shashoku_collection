<?php
App::uses('Component', 'Controller');

/**
 * クーポン関連で利用する関数を集約する
 */
class CouponsComponent extends Component {

	//コンポーネントをロード
    public $components = array(
    	'SetMenus'
    );

    /*
     * コントローラーを読み込む
     */
    public function initialize(Controller $controller) {

      $this->Controller = $controller;

    }

	/**
	 * 表示用のクーポンを取得する
	 * @param array $coupon_id
	 * @return array
	 */
    public function getOneCouponForDisp($coupon_id=null){

    	//変数の初期値を設定
    	$result = array();

    	//引数がない場合
    	if(is_null($coupon_id) || !is_numeric($coupon_id)){
    		return $result;
    	}

    	//クーポン関連のマスタを取得
    	$msts = $this->getMsts($coupon_id);
    	if(empty($msts)){
    		return $result;
    	}

    	//モデルをロード
    	$SetMenusPhoto 	= ClassRegistry::init('SetMenusPhoto');

    	//優先順位の最も高いセットメニューの写真を取得
		$msts['set_menu_photos'] 					= $SetMenusPhoto->getPrimaryRecord($msts['set_menu_photos']);
    	//レストラン名
    	$result['restaurant']['name'] 				= $msts['restaurants']['name'];
    	//クーポンの追加料金
    	$result['coupon']['additional_price'] 		= $msts['coupons']['additional_price'];
    	//クーポンの価格
    	$result['coupon']['price'] 					= $this->getTotalPrice($msts['coupons']['additional_price']);
    	//セットメニューの写真
    	$result['coupon']['set_menu']['photo_url'] 	= IMG_SET_MENUS_PHOTO.$msts['set_menu_photos']['file_name'];
    	//料理名
    	$result['coupon']['set_menu']['name'] 		= $msts['set_menus']['name'];

    	return $result;

    }

	/**
	 * クーポン関連のマスタを取得
	 * @param int    $coupon_id
	 * @return array
	 */
    public function getMsts($coupon_id){

    	//返却値を設定
    	$result = array();

    	//引数がない場合
    	if(empty($coupon_id)){
    		return $result;
    	}

    	//モデルをロード
		$Coupon 		= ClassRegistry::init('Coupon');
		$SetMenu 		= ClassRegistry::init('SetMenu');
		$SetMenusPhoto 	= ClassRegistry::init('SetMenusPhoto');
		$Restaurant 	= ClassRegistry::init('Restaurant');

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
    	$set_menu_photos = $SetMenusPhoto->find('all', array(
    		'conditions' => array(
    			'id' => $coupons['set_menu_id']
    		),
    		'cache' => true
    	));
    	if(empty($set_menu_photos)){
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

    	//返却値を作成
    	$result['coupons'] 			= $coupons;
    	$result['set_menus'] 		= $set_menus;
    	$result['set_menu_photos'] 	= $set_menu_photos;
    	$result['restaurants'] 		= $restaurants;

    	return $result;

    }

	/**
	 * １つのレストランに複数のクーポン情報を追加する
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
		$coupons = ArrayControl::removeKeys($coupons, array('id', 'restaurant_id', 'priority_order', 'set_menu_id', 'created', 'modified'));

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

	/**
	 * 基本料金を取得する
	 * @return array
	 */
    public function getBasicPrice(){

    	//返却値を設定
    	$result = 0;

    	//基本料金がない場合
		if(!isset($this->Controller->user_data['company']['basic_price'])){
			return $result;
		}

		//ユーザー除法から基礎料金を取得
		$result = $this->Controller->user_data['company']['basic_price'];

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