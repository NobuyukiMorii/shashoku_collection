<?php
App::uses('Component', 'Controller');

/**
 * セットメニュー関係で利用する関数を集約する
 */
class SetMenusComponent extends Component {

	/**
	 * セットメニューと１枚の写真を取得する
	 * @param array $set_menu_ids
	 * @return array
	 */
	public function getSetMenuWitPhoto($set_menu_ids){

		//返却値を設定
		$result = array();

		//引数がない場合
		if(empty($set_menu_ids)){
			return $result;
		}

		//モデルをロード
		$SetMenu 		= ClassRegistry::init('SetMenu');
		$SetMenusPhoto 	= ClassRegistry::init('SetMenusPhoto');

		//セットメニューを取得
		$set_menus = $SetMenu->find('all', array(
			'conditions' => array(
					'id' => $set_menu_ids
			),
			'cache' => true
		));
		//セットメニューがない場合
		if(empty($set_menus)){
			return $result;
		}

		//セットメニューの写真を取得
		$set_menus_photos = $SetMenusPhoto->find('all', array(
			'conditions' => array(
					'set_menu_id' => $set_menu_ids
			),
			'cache' => true
		));
		//セットメニューの写真がない場合
		if(empty($set_menus_photos)){
			return $result;
		}

		//セットメニューidごとに一番priority_orderの高い画像を取得
		$set_menus_photos = $SetMenusPhoto->getPrimaryRecordOfEachKey($set_menus_photos, 'set_menu_id');
		//写真がない場合
		if(empty($set_menus_photos)){
			
		}

		//セットメニューに写真を結合する
		foreach ($set_menus_photos as $key => $value) {

			//写真のセットメニューがあれば
			if(!empty($set_menus[$value['set_menu_id']])){

				//画像のパスを設定
				$path = IMG_SET_MENUS_PHOTO.$value['file_name'];

				//セットメニューに写真を付加
				$set_menus[$value['set_menu_id']]['photo_url'] = $path;

			}

		}

		//返却値に格納
		$result = $set_menus;

		return $result;

	}


}