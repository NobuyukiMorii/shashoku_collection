<?php
class RestaurantsController extends AppController {

	//コンポーネントをロード
    public $components = array(
        'Restaurants',
        'RestaurantsTags',
        'RestaurantsTagsRelations',
        'RestaurantsGenres',
        'RestaurantsGenresRelations',
        'RestaurantsPhotos',
        'Coupons',
        'Common'
    );
    
	/**
	 * レストラン一覧表示画面のアクション
	 * @return array
	 */
    public function index() {

        //----------------------------------------
        //法人id取得（仮）
        //----------------------------------------
		$company_id = 1;

        //----------------------------------------
        //レストラン取得
        //----------------------------------------
		$this->view_data['restaurants'] = $this->Restaurants->getRestaurantsByCompanyId($company_id);
		//レストランが取得出来ない場合
		if(empty($this->view_data['restaurants'])){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_DATA'), __('レストランが取得出来ません'));
			return;
		}
	
        //----------------------------------------
        //ジャンル取得
        //----------------------------------------
		$this->view_data['genres'] 		= $this->RestaurantsGenres->getRestaurantsGenres();
		//ジャンルが取得出来ない場合
		if(empty($this->view_data['genres'])){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_DATA'), __('ジャンルが取得出来ません'));
			return;
		}
			
        //----------------------------------------
        //タグ取得
        //----------------------------------------
		$this->view_data['tags'] 		= $this->RestaurantsTags->getRestaurantsTags();
		//レストランが取得出来ない場合
		if(empty($this->view_data['tags'])){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_DATA'), __('タグが取得出来ません'));
			return;
		}

    }

	/**
	 * レストラン詳細画面のアクション
	 * @return array
	 */
    public function detail() {

        //----------------------------------------
        //レストランidを取得
        //----------------------------------------
    	$restaurant_id = Arguments::getArguments('restaurant_id');
    	//レストランidが設定されなかった場合
    	if(is_null($restaurant_id) || !is_numeric($restaurant_id)){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_PARAM'), '対象のレストランが取得出来ません');	
			return;
    	}

        //----------------------------------------
        //レストラン取得
        //----------------------------------------
    	$this->view_data['restaurant'] = $this->Restaurants->getRestaurantById($restaurant_id);	
		//レストランが取得出来ない場合
		if(empty($this->view_data['restaurant'])){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_DATA'), __('レストランが取得出来ません'));
			return;
		}

        //----------------------------------------
        //ジャンル取得
        //----------------------------------------
		$this->view_data['genres'] 		= $this->RestaurantsGenres->getRestaurantsGenres();
		//ジャンルが取得出来ない場合
		if(empty($this->view_data['genres'])){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_DATA'), __('ジャンルが取得出来ません'));
			return;
		}
			
        //----------------------------------------
        //タグ取得
        //----------------------------------------
		$this->view_data['tags'] 		= $this->RestaurantsTags->getRestaurantsTags();
		//レストランが取得出来ない場合
		if(empty($this->view_data['tags'])){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_DATA'), __('タグが取得出来ません'));
			return;
		}

    }

}