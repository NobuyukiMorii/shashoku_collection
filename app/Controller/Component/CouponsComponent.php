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

		//クーポンとセットメニューを結合
		foreach ($coupons as $key => $value) {

			//クーポンの対象のセットメニューがあれば
			if(!empty($set_menus[$value['set_menu_id']])){

				//セットメニュー名を追加
				$coupons[$key]['set_menu']['name'] 				= $set_menus[$value['set_menu_id']]['name'];

				//セットメニューの説明文を追加
				$coupons[$key]['set_menu']['description'] 		= $set_menus[$value['set_menu_id']]['description'];			

				//写真を追加
				$coupons[$key]['set_menu']['photo_url'] 		= $set_menus[$value['set_menu_id']]['photo_url'];

			}

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

		/* 優先順位の一番高いレストランにクーポンを追加する */
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
	    		$restaurants[$value['restaurant_id']]['coupons']['price']			= $value['price'];

	    		//セットメニューの名前を追加する
	    		if(!empty($set_menus[$value['set_menu_id']]['name'])){

	    			$restaurants[$value['restaurant_id']]['coupons']['set_menu_name']	= $set_menus[$value['set_menu_id']]['name'];

	    		}

	    	}

    	}

    	return $restaurants;

    }

}