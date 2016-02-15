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

        //法人idを配列で取得
        $users_companies_locations_ids = Hash::extract($users_companies_locations_relations, '{n}.companies_location_id');

        //法人を取得
        $location = $CompaniesLocation->find('all', array(
            'conditions' => array(
                'id' => $users_companies_locations_ids
            ),
            'cache' => true
        ));
        if(empty($location)){
            return $result;
        }

        //id順に並び変える
        $result = Hash::sort($location, '{n}.id');

        return $result;

	}

}