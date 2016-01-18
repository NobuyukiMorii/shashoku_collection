<?php
App::uses('Component', 'Controller');

/**
 * レストランタグ関係で利用する関数を集約する
 */
class RestaurantsTagsComponent extends Component {

	/**
	 *レストランタグをカラーコード付で取得する
	 * @return array
	 */
    public function getRestaurantsTags(){

    	//返却値を設定
    	$result = array();

    	//モデルをロードする
    	$RestaurantsTag = ClassRegistry::init('RestaurantsTag');
    	$Color 			= ClassRegistry::init('Color');

    	//マスタを取得する
    	$restaurants_tags 	= $RestaurantsTag->find('all', array('cache' => true));
    	$colors 			= $Color->find('all', array('cache' => true));

    	//データがない場合
    	if(empty($restaurants_tags) || empty($colors)){
    		return $result;
    	}

		//レストランのタグを返却値用に整形する 
		$result = ArrayControl::extractTargetKeys($restaurants_tags , 'name', 'color_id');

		//レストランのタグのカラーidをカラーコードに変換する 
		$result = ArrayControl::replaceIdToValue($result, $colors, 'color_id', 'color_code');


		//値を返却
		return $result;

    }

}