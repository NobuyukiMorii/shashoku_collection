<?php
class RestaurantsController extends AppController {

	//モデルをロード
	public $uses = array(
		'Coupon', 
		'Restaurant',
		'SetMenusPhoto',
		'SetMenu', 
		'RestaurantsPhoto', 
		'RestaurantsGenre', 
		'RestaurantsGenresRelation', 
		'RestaurantsTag', 
		'RestaurantsTagsRelation', 
		'CompaniesRestaurantsRelation',
		'Color'
	);

	//コンポーネントをロード
    public $components = array(
        'Restaurants',
        'RestaurantsTags',
        'RestaurantsTagsRelations',
        'RestaurantsGenres',
        'RestaurantsGenresRelations',
        'RestaurantsPhotos',
        'Coupons'
    );
    
	/**
	 * レストラン一覧表示画面のアクション
	 *
	 * @return array
	 */
    public function index() {

    	//法人idを取得（仮）
		$company_id = 1;

		//法人の利用可能なレストランを取得
		$restaurants = $this->Restaurants->getWashedRestaurantsByCompanyId($company_id);

		//返却用レストランのジャンル
		$genres = $this->RestaurantsGenres->getRestaurantsGenres();

		//返却用レストランのタグ
		$tags = $this->RestaurantsTags->getRestaurantsTags();

		//viewに値を返却する
		$this->set(compact('restaurants', 'genres',  'tags'));

    }

	/**
	 * レストラン詳細画面のアクション
	 * @return array
	 */
    public function detail() {

    	//レストランidを取得
    	$restaurant_id = Arguments::getArguments('restaurant_id');

    	//レストランidが設定されなかった場合
    	if(empty($restaurant_id)){
    		//エラーとする
    		exit;
    	}

    	//レストランを取得
		$restaurant = $this->Restaurant->find('first', array(
			'conditions' => array(
				'id' => $restaurant_id
			),
			'cache' => true
		));

    	//レストランが存在しない場合
    	if(empty($restaurant)){
    		//エラーとする
    		exit;
    	}

		//ジャンルidを追加
		$restaurant = $this->RestaurantsGenresRelations->AddGenreIdToRestaurant($restaurant);

		//タグidを追加
		$restaurant = $this->RestaurantsTagsRelations->AddTagIdsToRestaurant($restaurant);

		//レストラン画像を追加
		$restaurant = $this->RestaurantsPhotos->AddPhotosToRestaurant($restaurant);

		//クーポンとメニューを追加
		$restaurant = $this->Coupons->AddCouponsInfoToRestaurant($restaurant);		

		//返却用レストランのジャンル
		$genres = $this->RestaurantsGenres->getRestaurantsGenres();

		//返却用レストランのタグ
		$tags = $this->RestaurantsTags->getRestaurantsTags();

		//viewに値を返却する
		$this->set(compact('restaurant', 'genres',  'tags'));

    }

}