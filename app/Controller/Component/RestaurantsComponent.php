<?php
App::uses('Component', 'Controller');

/**
 * レストランのマスタデータを加工する関数を集約する
 */
class RestaurantsComponent extends Component {

	//コンポーネントをロード
    public $components = array(
    	'FindSupport',
        'RestaurantsTagsRelations',
        'RestaurantsGenresRelations',
        'RestaurantsPhotos',
        'Coupons'
    );

	//----------------------------------------
	//１//
	//action:index
	//最終的にviewに表示するレストラン情報を取得するメソッド
	//----------------------------------------

	/**
	 * 返却用のレストランを取得。
	 * ①レストランに関連するマスタを全て取得。
	 * ②返却用レストランを作成。
	 * @param  array $company_id
	 * @return array
	 */
	public function getWashedRestaurantsByCompanyId($company_id){

		//返却値を設定
		$restaurants = array();		

		//引数がないか、数字ではない場合
    	if(is_null($company_id) || !is_numeric($company_id)){
    		return $restaurants;
    	}

		//関連マスタを取得
		$msts = $this->getWashedRestaurantsRelatedMasterByCompanyId($company_id);
		//エラーハンドリング
		$flg = ArrayControl::multipleHashEmptyCheck($msts, array('restaurants', 'coupons', 'set_menus', 'restaurants_photos', 'restaurants_genres_relations', 'restaurants_tags_relations'));
		if($flg === false){
			return $result;
		}

        //返却用レストランを取得
        $restaurants = $this->getRestaurants($msts['restaurants'], $msts['coupons'], $msts['set_menus'], $msts['restaurants_photos'], $msts['restaurants_genres_relations'], $msts['restaurants_tags_relations']);

        return $restaurants;

	}

	//----------------------------------------
	//２//
	//action:index
	//1のgetWashedRestaurantsByCompanyIdメソッド内の①「レストランに関連するマスタを全て取得」に関連するメソッド群
	//----------------------------------------

	/**
	 * レストランに関連するマスタを全て取得。
	 * （イレギュラーなデータを削除しています。）
	 * @param  array $company_id
	 * @return array
	 */
	public function getWashedRestaurantsRelatedMasterByCompanyId($company_id){

    	//返却値を作成
    	$result = array();

    	//引数がないか数字ではない場合
    	if(is_null($company_id) || !is_numeric($company_id)){
    		return $result;
    	}

    	//レストランの関連マスタを全て取得（レストラン以外）
    	$related_models = array(
			'Coupon', 
			'SetMenusPhoto',
			'SetMenu', 
			'RestaurantsPhoto', 
			'RestaurantsGenresRelation', 
			'RestaurantsTagsRelation', 
    	);
    	$result = $this->FindSupport->multipleFindCache($related_models);

    	//エラーハンドリング
		$flg = ArrayControl::multipleHashEmptyCheck($result, array('coupons', 'set_menus', 'restaurants_photos', 'restaurants_genres_relations', 'restaurants_tags_relations'));
		if($flg === false){
			return $result;
		}

    	//法人が現在利用可能なレストランを取得
		$result['restaurants'] = $this->getRestaurantsByCompanyId($company_id);
		//エラーハンドリング
		if(empty($result['restaurants'])){
			return $result;
		}


        //不完全なレコードを除去（期間外&他テーブルに必要な情報がない場合。開発環境でのみログを残しています。）
        //セットメニューを除去してから、クーポンを除去し、最後にレストランを除去する構成
		$wash_models = array('SetMenu', 'Coupon', 'Restaurant',);
    	$result = $this->FindSupport->washMasterData($wash_models, $result, __FILE__, __METHOD__, __LINE__);

    	return $result;

	}

	/**
	 * 返却用のレストランを取得する
	 * @param array $restaurants
	 * @param array $coupons
	 * @param array $set_menus
	 * @param array $restaurants_photos
	 * @param array $restaurants_genres_relations
	 * @param array $restaurants_tags_relations
	 * @return array
	 */
	public function getRestaurants($restaurants, $coupons, $set_menus, $restaurants_photos, $restaurants_genres_relations, $restaurants_tags_relations){

    	//返却値を作成
    	$result = array();

		//引数をチェック
		$flg = ArrayControl::multipleEmptyCheck($restaurants, $coupons, $set_menus, $restaurants_photos, $restaurants_genres_relations, $restaurants_tags_relations);
		if($flg === false){
			return $result;
		}

    	//レストランに関連情報を付加
        $result = $this->addRelatedDataToRestaurants($restaurants, $coupons, $set_menus, $restaurants_photos, $restaurants_genres_relations, $restaurants_tags_relations);
        if(empty($result)){
        	return $result;
        }

        //レストランから不必要なキーを除去
        $result = ArrayControl::removeKeys($result, array('description', 'address', 'phone_num', 'seats_num', 'regular_holiday', 'url', 'lunch_time', 'open_time', 'smoke_flg', 'reservation_flg', 'created', 'modified'));

        //値を返却
        return $result;

	}

    /**
     * 法人の利用可能なレストランを取得
     * @param  array  $restaurants
     * @param  int    $company_id
     * @return array
     */
	public function getRestaurantsByCompanyId($company_id){

		//返却値を設定
		$result = array();

		//引数が不足していた場合
		if(is_null($company_id)){
			//空配列で返却
			return $result;
		}

		//レストランidを取得
		$restaurant_ids = $this->getRestaurantsIdByCompanyId($company_id);

		//モデルをロード
		$Restaurant = ClassRegistry::init('Restaurant');

		//レストランを取得
		$restaurants = $Restaurant->find('all', array('cache' => true));
		if(empty($restaurants)){
			return $result;
		}

    	//レストランidをループする
    	foreach ($restaurant_ids as $restaurant_id) {

    		//レストラン情報を格納する
    		if(!empty($restaurants[$restaurant_id])){

    			$result[$restaurant_id] = $restaurants[$restaurant_id];

    		} else {

                //エラーログを出力（開発環境のみ）
                $message = "法人id".$company_id."に".$restaurant_id."が登録されていますが、対象のレストランは存在しませんでした。";
                Util::OriginalLog($file, __method__, __line__, __message__);

    		}

    	}

    	return $result;

	}

	//----------------------------------------
	//３//
	//action:index
	//1のgetWashedRestaurantsByCompanyIdメソッド内の②「返却用レストランを作成」に関連するメソッド
	//----------------------------------------

    /**
     * 法人の利用可能なレストランidを取得
     * @param  int    $company_id
     * @return array
     */
	public function getRestaurantsIdByCompanyId($company_id){

		//返却値を設定
		$result = array();

		//法人idがnullか数字ではない場合
		if(is_null($company_id) || !is_numeric($company_id)){
			//空配列で返却
			return $result;
		}

		//モデルをロード
		$CompaniesRestaurantsRelation = ClassRegistry::init('CompaniesRestaurantsRelation');

		//法人の利用可能なレストランを全て取得
		$companies_restaurants_relations = $CompaniesRestaurantsRelation->find('all', array(
			'conditions' => array(
				'company_id' => $company_id
			),
			'cache' => true
		));

		//対象のレストランが登録されていない場合
		if(empty($companies_restaurants_relations)) {
			return $result;
		}

		//有効期間外のレストランを除外する
		$companies_restaurants_relations = $CompaniesRestaurantsRelation->extractRecordInPeriod($companies_restaurants_relations);
		//全てが有効期間外の場合
		if(empty($companies_restaurants_relations)) {
			return $result;
		}

		//対象のレストランidを抽出する
		$result = Hash::extract($companies_restaurants_relations, '{n}.restaurant_id');

		return $result;

	}

	/**
	 * レストランに関連情報を付加する
	 * @param array $restaurants
	 * @param array $coupons
	 * @param array $set_menus
	 * @param array $restaurants_photos
	 * @param array $restaurants_genres_relations
	 * @param array $restaurants_tags_relations
	 * @return array
	 */
    public function addRelatedDataToRestaurants($restaurants, $coupons, $set_menus, $restaurants_photos, $restaurants_genres_relations, $restaurants_tags_relations){

    	//返却値を作成
    	$result = array();

    	//レストランがない場合
    	if(empty($restaurants)){
    		return $result;
    	}

    	//返却値にレストランを格納する
    	$result = $restaurants;

		//クーポンとセットメニューがあれば
		if(!empty($coupons) && !empty($set_menus)){
			/* レストランにクーポンを追加する */	
			$result = $this->Coupons->AddCouponInfoToRestaurants($result, $coupons , $set_menus);
			if(empty($result)){
				return $result;
			}
		}

		//レストランの写真があれば
		if(!empty($restaurants_photos)){
			/* レストランに写真を追加する */
			$result = $this->RestaurantsPhotos->AddPrimaryPhotoToRestaurants($result, $restaurants_photos);
			if(empty($result)){
				return $result;
			}
		}

		//レストランのジャンル関連性があれば
		if(!empty($restaurants_genres_relations)){
			/* レストランにジャンルにジャンルidを追加する */
			$result = $this->RestaurantsGenresRelations->AddPrimaryGenreIdToRestaurants($result, $restaurants_genres_relations);	
			if(empty($result)){
				return $result;
			}
		}

		//レストランのタグ関連性があれば
		if(!empty($restaurants_tags_relations)){
			/* タグidをレストランに追加する */
			$result = $this->RestaurantsTagsRelations->AddPrimaryTagIdToRestaurants($result, $restaurants_tags_relations);
			if(empty($result)){
				return $result;
			}

		}

		return $result;

    }

	//----------------------------------------
	//４//
	//action:detail
	//----------------------------------------

    /**
     * レストランidから、レストランを取得
     * @param  int   $restaurant_id
     * @return array
     */
	public function getRestaurantById($restaurant_id){

		//引数がないか、数字ではない場合
    	if(is_null($restaurant_id) || !is_numeric($restaurant_id)){
    		return array();
    	}

		//モデルをロード
		$Restaurant = ClassRegistry::init('Restaurant');

    	//レストランを取得
		$restaurant = $Restaurant->find('first', array(
			'conditions' => array(
				'id' => $restaurant_id
			),
			'cache' => true
		));

    	//レストランが存在しない場合
    	if(empty($restaurant)){
    		//エラーとする
    		return array();
    	}

		//ジャンルidを追加
		$restaurant = $this->RestaurantsGenresRelations->AddGenreIdToRestaurant($restaurant);
		if(empty($restaurant)){
			return array();
		}

		//タグidを追加
		$restaurant = $this->RestaurantsTagsRelations->AddTagIdsToRestaurant($restaurant);
		if(empty($restaurant)){
			return array();
		}

		//レストラン画像を追加
		$restaurant = $this->RestaurantsPhotos->AddPhotosToRestaurant($restaurant);
		if(empty($restaurant)){
			return array();
		}

		//クーポンとメニューを追加
		$restaurant = $this->Coupons->AddCouponsInfoToRestaurant($restaurant);		
		if(empty($restaurant)){
			return array();
		}
		
		return $restaurant;

	} 

}