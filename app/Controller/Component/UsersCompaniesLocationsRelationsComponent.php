<?php
App::uses('Component', 'Controller');

/**
 * ユーザー法人所在地関連性で利用する関数を集約する
 */
class UsersCompaniesLocationsRelationsComponent extends Component {

    /**
     * user_idから、所在地情報を取得
     * @param  int   $user_id
     * @return array
     */
	public function getLocationInfo($user_id){

		//返却値を設定
		$result = array();

		//引数がない場合
    	if(is_null($user_id) || !is_numeric($user_id)){
    		return $result;
    	}

    	//モデルをロード
		$UsersCompaniesLocationsRelation 	= ClassRegistry::init('UsersCompaniesLocationsRelation');
		$CompaniesLocation 					= ClassRegistry::init('CompaniesLocation');

		//ユーザー法人関連性
        $users_companies_locations_relations = $UsersCompaniesLocationsRelation->find('all', array(
            'conditions' => array(
                'user_id' => $user_id
            )
        ));

        //ユーザーに法人登録がない場合
        if(empty($users_companies_locations_relations)){
        	return $result;
        }

        //優先順位順に並び変える
        $users_companies_locations_relations = Hash::sort($users_companies_locations_relations, '{n}.priority_order');

        //法人idを配列で取得
        $users_companies_locations_ids = Hash::extract($users_companies_locations_relations, '{n}.companies_location_id');
        //上記配列を文字列にする
        $users_companies_locations_ids_string = implode(",", $users_companies_locations_ids);

        //法人を取得
        $location = $CompaniesLocation->find('all', array(
            'conditions' => array(
                'id' => $users_companies_locations_ids
            ),
            'order' =>  array('FIELD(CompaniesLocation.id, ' . $users_companies_locations_ids_string . ')'),
            'cache' => true
        ));
        if(empty($location)){
            return $result;
        }

        //キーを0,1,2とする
        $result = ArrayControl::changeKeyToNaturalNum($location);

        return $result;

	}

}