<?php
App::uses('Component', 'Controller');

/**
 * ユーザーで利用する関数を集約する
 */
class UsersComponent extends Component {

	//コンポーネントをロード
    public $components = array(
    	'UsersCompaniesLocationsRelations',
    	'UsersCompaniesDepartmentsRelations',
    	'Session',
        'Auth'
    );

    /**
     * ログイン中のユーザーの情報をSessionに格納
     * @param  int   $user_id
     * @return array
     */
	public function setAuthSession($user_id){

		//返却値を設定
		$result = array();

		//引数がない場合
    	if(is_null($user_id) || !is_numeric($user_id)){
    		return $result;
    	}

    	//ユーザー情報取得
    	$user_data = $this->getUserData($user_id);
    	if(empty($user_data)){
    		return $result;
    	}

		//セッションに保存
		$flg = $this->Session->write('Auth', $user_data);

		//成功したら、ユーザーデータを返却値に格納
		if($flg === true){
			return $result = $user_data;
		}

		return $result;

	}

    /**
     * ユーザーに関連するマスタを取得
     * @param  int   $user_id
     * @return array
     */
	public function getUserData($user_id){

		//返却値を設定
		$result = array();

		//引数がない場合
    	if(is_null($user_id) || !is_numeric($user_id)){
    		return $result;
    	}

    	//モデルをロード
		$User 								= ClassRegistry::init('User');
		$UsersProfile 						= ClassRegistry::init('UsersProfile');
		$Company 							= ClassRegistry::init('Company');

		//ユーザー取得
        $result = $this->Auth->user();

        $result['User'] = $User->find('first', array(
            'conditions' => array(
                'id' => $user_id
            ),
            'cache' => true
        ));
        if(empty($result['User'])){
        	return array();
        }

        //プロフィール取得
        $result['UsersProfile'] = $UsersProfile->find('first', array(
            'conditions' => array(
                'user_id' => $user_id
            ),
            'cache' => true
        ));
        if(empty($result['UsersProfile'])){
        	return array();
        }

		//法人取得
        $result['Company'] = $Company->find('first', array(
            'conditions' => array(
                'id' => $result['User']['company_id']
            ),
            'cache' => true
        ));
        if(empty($result['Company'])){
        	return array();
        }

        //部署名取得
        $result['CompaniesDepartment'] = $this->UsersCompaniesDepartmentsRelations->getDepartmentInfo($user_id);
        if(empty($result['CompaniesDepartment'])){
        	return array();
        }

        //所在地取得
        $result['CompaniesLocation'] = $this->UsersCompaniesLocationsRelations->getLocationInfo($user_id);
        if(empty($result['CompaniesLocation'])){
        	return array();
        }

        return $result;

	}




}