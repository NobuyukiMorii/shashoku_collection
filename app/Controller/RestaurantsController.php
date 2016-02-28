<?php
class RestaurantsController extends AppController {

	//コンポーネントをロード
    public $components = array(
    	'Companies',
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
	 * @return array
	 */
    public function index() {

        $this->title = "レストラン一覧";
        //----------------------------------------
        //レストラン取得
        //----------------------------------------
		$this->view_data['restaurants'] = $this->Restaurants->getRestaurants();
		//レストランが取得出来ない場合
		if(empty($this->view_data['restaurants'])){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_DATA'), __('レストランが取得出来ません。'));
			return;
		}

        //----------------------------------------
        //ジャンル取得
        //----------------------------------------
		$this->view_data['genres'] 		= $this->RestaurantsGenres->getRestaurantsGenres();
		//ジャンルが取得出来ない場合
		if(empty($this->view_data['genres'])){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_DATA'), __('ジャンルが取得出来ません。'));
			return;
		}
			
        //----------------------------------------
        //タグ取得
        //----------------------------------------
		$this->view_data['tags'] 		= $this->RestaurantsTags->getRestaurantsTags();
		//レストランが取得出来ない場合
		if(empty($this->view_data['tags'])){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_DATA'), __('タグが取得出来ません。'));
			return;
		}

		return $this->view_data;

    }

	/**
	 * レストラン詳細画面のアクション
	 * @param  int   $restaurant_id
	 * @return array
	 */
    public function detail($restaurant_id=null) {

        //----------------------------------------
        //レストランidを取得
        //----------------------------------------
        if(empty($restaurant_id)){
    		$restaurant_id = Arguments::getArguments('restaurant_id');
    	}
    	//レストランidが設定されなかった場合
    	if(is_null($restaurant_id) || !is_numeric($restaurant_id)){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_PARAM'), __('対象のレストランが取得出来ません。'));	
			return;
    	}

        //----------------------------------------
        //レストラン取得
        //----------------------------------------
    	$this->view_data['restaurant'] = $this->Restaurants->getRestaurantById($restaurant_id);	
		//レストランが取得出来ない場合
		if(empty($this->view_data['restaurant'])){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_DATA'), __('レストランが取得出来ません。'));
			return;
		}

        //----------------------------------------
        //ジャンル取得
        //----------------------------------------
		$this->view_data['genres'] 		= $this->RestaurantsGenres->getRestaurantsGenres();
		//ジャンルが取得出来ない場合
		if(empty($this->view_data['genres'])){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_DATA'), __('ジャンルが取得出来ません。'));
			return;
		}
			
        //----------------------------------------
        //タグ取得
        //----------------------------------------
		$this->view_data['tags'] 		= $this->RestaurantsTags->getRestaurantsTags();
		//レストランが取得出来ない場合
		if(empty($this->view_data['tags'])){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_DATA'), __('タグが取得出来ません。'));
			return;
		}

		return $this->view_data;

    }

}