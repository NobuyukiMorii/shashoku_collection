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

	/**
	 * レストランに関連するマスタを全て取得します。
	 * イレギュラーなデータを削除しています。
	 * @param  array $company_id
	 * @return array
	 */
	public function getWashedRestaurantsByCompanyId($company_id){

		//関連マスタを取得
		$msts = $this->getWashedRestaurantsRelatedMasterByCompanyId($company_id);

        //返却用レストランを取得
        $restaurants = $this->getRestaurants($msts['restaurants'], $msts['coupons'], $msts['set_menus'], $msts['restaurants_photos'], $msts['restaurants_genres_relations'], $msts['restaurants_tags_relations']);

        return $restaurants;

	}

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

    	//キャッシュを参照する

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

	    	//法人が現在利用可能なレストランを取得
			$result['restaurants'] = $this->getRestaurantsByCompanyId($company_id);

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

    	//レストランがない場合
    	if(empty($restaurants)){
    		return $result;
    	}

    	//レストランに関連情報を付加
        $result = $this->addRelatedDataToRestaurants($restaurants, $coupons, $set_menus, $restaurants_photos, $restaurants_genres_relations, $restaurants_tags_relations);

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
		$restaurant_ids = $this->getRestaurantIdByCompanyId($company_id);

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

    /**
     * 法人の利用可能なレストランidを取得
     * @param  int    $company_id
     * @return array
     */
	public function getRestaurantIdByCompanyId($company_id){

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
		}

		//レストランの写真があれば
		if(!empty($restaurants_photos)){
			/* レストランに写真を追加する */
			$result = $this->RestaurantsPhotos->AddPrimaryPhotoToRestaurants($result, $restaurants_photos);
		}

		//レストランのジャンル関連性があれば
		if(!empty($restaurants_genres_relations)){
			/* レストランにジャンルにジャンルidを追加する */
			$result = $this->RestaurantsGenresRelations->AddPrimaryGenreIdToRestaurants($result, $restaurants_genres_relations);	
		}

		//レストランのタグ関連性があれば
		if(!empty($restaurants_tags_relations)){

			/* タグidをレストランに追加する */
			$result = $this->RestaurantsTagsRelations->AddPrimaryTagIdToRestaurants($result, $restaurants_tags_relations);			

		}

		return $result;

    }

}