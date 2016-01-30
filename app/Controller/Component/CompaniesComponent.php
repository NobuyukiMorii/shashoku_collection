<?php
App::uses('Component', 'Controller');

/**
 * 会社関連で利用する関数を集約する
 */
class CompaniesComponent extends Component {

	/**
	 * 対象のidの会社を取得する
	 * @param array $company_id
	 * @return array
	 */
    public function getCompanyById($company_id){

    	//結果の初期値を設定
    	$result = array();

    	//会社idが設定されなかった場合
    	if(is_null($company_id) || !is_numeric($company_id)){
    		//空で返却
			return $result;
    	}

    	//モデルをロード
		$Company = ClassRegistry::init('Company');

		//会社idを検索
		$company = $Company->find('first', array(
			'conditions' => array(
				'id' => $company_id
			),
			'cache' => true
		));

		return $company;

    }

}