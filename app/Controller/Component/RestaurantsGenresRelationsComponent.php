<?php
App::uses('Component', 'Controller');

/**
 * レストランジャンル関連性で利用する関数を集約する
 */
class RestaurantsGenresRelationsComponent extends Component {

	/**
	 * １つのレストランに１つのジャンルidを追加する
	 * 優先順位の一番高いジャンルidを追加する
	 * @param array $restaurant
	 * @return array
	 */
    public function AddGenreIdToRestaurant($restaurant){

    	//引数をチェック
    	if(empty($restaurant)){
    		return array();
    	}

		//モデルをロード
		$RestaurantsGenresRelation = ClassRegistry::init('RestaurantsGenresRelation');

		//ジャンルidを取得
		$restaurants_genres_relation = $RestaurantsGenresRelation->find('all', array(
			'conditions' => array(
				'restaurant_id' => $restaurant['id']
			),
			'cache' => true
		));

		//対象のジャンルが存在しない場合
		if(empty($restaurants_genres_relation)){

			//空配列を格納
			$restaurant['genre_id'] = array();
			return $restaurant;

		}

		//priority_order順に並び変える
		$restaurants_genres_relation = Hash::sort($restaurants_genres_relation, '{n}.priority_order');

		//ジャンルidを抽出
		$genre_ids = hash::extract($restaurants_genres_relation, '{n}.resaurant_genre_id');

		//ジャンルidを追加
		$restaurant['genre_id'] = $genre_ids[0];

		return $restaurant;

    }

	/**
	 * それぞれのレストランにジャンルidを追加する
	 * （優先順位が最も高いジャンルのみ）
	 * @param array $restaurants
	 * @param array $coupons
	 * @return array
	 */
    public function AddPrimaryGenreIdToRestaurants($restaurants, $restaurants_genres_relations){

    	$flg = ArrayControl::multipleEmptyCheck($restaurants, $restaurants_genres_relations);
    	if($flg === false){
    		return array();
    	}

		//レストランごとに、優先順位の高いジャンル関連idを取得する
		$RestaurantsGenresRelation = ClassRegistry::init('RestaurantsGenresRelation');
		$primary_genres_relations = $RestaurantsGenresRelation->getPrimaryRecordOfEachKey($restaurants_genres_relations, 'restaurant_id');
		if(empty($primary_genres_relations)){
			return array();
		}

		//レストランのジャンルをループ
		foreach ($primary_genres_relations as $key => $value) {

			//対象のレストランがあれば
			if(!empty($restaurants[$value['restaurant_id']])) {

				//ジャンルidを追加する
				$restaurants[$value['restaurant_id']]['genres_id'] = $value['resaurant_genre_id'];

			}

		}

		return $restaurants;

    }

}