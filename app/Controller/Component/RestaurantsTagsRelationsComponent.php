<?php
App::uses('Component', 'Controller');

/**
 * レストランタグ関連性で利用する関数を集約する
 */
class RestaurantsTagsRelationsComponent extends Component {

	/**
	 * １つのレストランにタグidを追加する
	 * priority_order順
	 * @param array $restaurant
	 * @return array
	 */
    public function AddTagIdsToRestaurant($restaurant){

    	//引数をチェック
    	if(empty($restaurant)){
    		return array();
    	}

		//モデルをロード
		$RestaurantsTagsRelation = ClassRegistry::init('RestaurantsTagsRelation');

		//ジャンルidを取得
		$restaurants_tags_relation = $RestaurantsTagsRelation->find('all', array(
			'conditions' => array(
				'restaurant_id' => $restaurant['id']
			),
			'cache' => true
		));

		//対象のタグが存在しない場合
		if(empty($restaurants_tags_relation)){

			//値を空配列として健脚
			$restaurant['image'] = array();
			return $restaurant;
			
		}

		//priority_order順に並び変える
		$restaurants_tags_relation = Hash::sort($restaurants_tags_relation, '{n}.priority_order');

		//ジャンルidを抽出
		$tag_ids = hash::extract($restaurants_tags_relation, '{n}.resaurant_tag_id');

		//ジャンルidを追加
		$restaurant['tag_ids'] = $tag_ids;

		return $restaurant;

    }

	/**
	 * それぞれのレストランにタグidを追加する
	 * （優先順位が高いタグのみ（最大２つ））
	 * @param  array $restaurants
	 * @param  array $restaurants_tags_relations
	 * @return array
	 */
    public function AddPrimaryTagIdToRestaurants($restaurants, $restaurants_tags_relations){

    	//引数チェック
    	$flg = ArrayControl::multipleEmptyCheck($restaurants, $restaurants_tags_relations);
    	if($flg === false) {
    		return array();
    	}

		//レストランごとに、優先順位が高いタグ関連レコードを２つ取得する
		$RestaurantsTagsRelation = ClassRegistry::init('RestaurantsTagsRelation');
		$primary_tag_relations = $RestaurantsTagsRelation->getPrimaryRecordsOfEachKey($restaurants_tags_relations, 'restaurant_id', 2);
		if(empty($primary_tag_relations)){
			return array();
		}

		//レストランのタグ関連性をループ
		foreach ($primary_tag_relations as $key => $tags) {

			//タグ関連性をループ
			foreach ($tags as $tag_key => $tag_value) {

				//対象のレストランがあれば
				if(!empty($restaurants[$tag_value['restaurant_id']])){

					//タグを追加する
					$restaurants[$tag_value['restaurant_id']]['tag_id'][] = $tag_value['resaurant_tag_id'];

				}

			}

		}

		return $restaurants;

    }

}