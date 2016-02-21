<?php
App::uses('Component', 'Controller');

/**
 * ユーザー法人部署関係性で利用する関数を集約する
 */
class UsersCompaniesDepartmentsRelationsComponent extends Component {

    /**
     * user_idから、部署情報を取得
     * @param  int   $user_id
     * @return array
     */
	public function getDepartmentInfo($user_id){

		//返却値を設定
		$result = array();

		//引数がない場合
    	if(is_null($user_id) || !is_numeric($user_id)){
    		return $result;
    	}

    	//モデルをロード
		$UsersCompaniesDepartmentsRelation 	= ClassRegistry::init('UsersCompaniesDepartmentsRelation');
		$CompaniesDepartment 				= ClassRegistry::init('CompaniesDepartment');

		//ユーザー部署関係性取得
        $users_companies_departments_relation = $UsersCompaniesDepartmentsRelation->find('all', array(
            'conditions' => array(
                'user_id' => $user_id
            ),
            'cache' => true
        ));

        //ユーザーに関係部署が登録されていない場合
        if(empty($users_companies_departments_relation)){
        	return $result;
        }

        //優先順位順に並び変える
        $users_companies_departments_relation = Hash::sort($users_companies_departments_relation, '{n}.priority_order');

        //ユーザーidをキーとした配列とする
		$users_companies_departments_ids = Hash::extract($users_companies_departments_relation, '{n}.companies_department_id');
        //上記配列を文字列にする
        $users_companies_departments_ids_string = implode(",", $users_companies_departments_ids);

		//部署を優先順位順に取得
        $department = $CompaniesDepartment->find('all', array(
            'conditions' => array(
                'id' => $users_companies_departments_ids
            ),
            'order' =>  array('FIELD(CompaniesDepartment.id, ' . $users_companies_departments_ids_string . ')'),
            'cache' => true
        ));
        if(empty($department)){
            return $result;
        }

        //キーを0,1,2とする
        $result = ArrayControl::changeKeyToNaturalNum($department);

        return $result;

	}

}