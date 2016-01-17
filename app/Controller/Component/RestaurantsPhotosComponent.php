<?php
App::uses('Component', 'Controller');

/**
 * レストランの写真で利用する関数を集約する
 */
class RestaurantsPhotosComponent extends Component {

	/**
	 * １つのレストランに写真を追加する
	 * 優先順位順
	 * @param array $restaurants
	 * @return array
	 */
    public function AddPhotosToRestaurant($restaurant){

		//モデルをロード
		$RestaurantsPhoto = ClassRegistry::init('RestaurantsPhoto');

		//写真を取得
		$restaurants_photos = $RestaurantsPhoto->find('all', array(
			'conditions' => array(
				'restaurant_id' => $restaurant['id']
			),
			'cache' => true
		));

		//対象のタグが存在しない場合
		if(empty($restaurants_photos)){

			//値を空配列として健脚
			$restaurant['tag_ids'] = array();
			return $restaurant;
			
		}

		//priority_order順に並び変える
		$restaurants_photos = Hash::sort($restaurants_photos, '{n}.priority_order');

		//レストランの写真をループする
		foreach ($restaurants_photos as $key => $value) {

			//レストランの画像が格納されているフォルダへのパスを取得する（webroot/index.phpにて画像までのパスを定数）
			$path =  IMG_RESTAURANTS_PHOTO .$value['file_name'];

			//画像のパスを格納
			$photo_url[$key] = $path;

		}

		//レストランに写真を追加
		$restaurant['photo_url'] = $photo_url;

		return $restaurant;

    }

	/**
	 * それぞれのレストランに写真を追加する
	 * （優先順位が最も高い写真のみ）
	 * @param array $restaurants
	 * @param array $restaurants_photos
	 * @return array
	 */
    public function AddPrimaryPhotoToRestaurants($restaurants, $restaurants_photos){

		//レストランidごとに、１番優先順位の高い画像を取得する
		$RestaurantsPhoto = ClassRegistry::init('RestaurantsPhoto');
		$restaurants_photos = $RestaurantsPhoto->getPrimaryRecordOfEachKey($restaurants_photos, 'restaurant_id');

		//レストランの写真をループする
		foreach ($restaurants_photos as $key => $value) {

			//対象のレストランがあれば
			if(!empty($restaurants[$value['restaurant_id']])) {

				//レストランの画像が格納されているフォルダへのパスを取得する（webroot/index.phpにて画像までのパスを定数）
				$path =  IMG_RESTAURANTS_PHOTO .$value['file_name'];

				//画像のパスを格納
				$restaurants[$value['restaurant_id']]['photo_url'] = $path;

			}

		}

		return $restaurants;

    }

}