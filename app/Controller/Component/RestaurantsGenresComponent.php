<?php
App::uses('Component', 'Controller');

/**
 * レストランジャンル関係で利用する関数を集約する
 */
class RestaurantsGenresComponent extends Component {

	/**
     * レストランジャンルを取得する
	 * @return array
	 */
    public function getRestaurantsGenres(){

        //返却値を設定
        $result = array();

        //モデルをロードする
        $RestaurantsGenres = ClassRegistry::init('RestaurantsGenres');

        //マスタを取得する
        $restaurants_genres = $RestaurantsGenres->find('all', array('cache' => true));

        //データがない場合
        if(empty($restaurants_genres)) {
            return $result;
        }

        //結果を格納する
        $result = ArrayControl::extractTargetKeys($restaurants_genres, 'name');

        //値を返却
        return $result;

    }

}