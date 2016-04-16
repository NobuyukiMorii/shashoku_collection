<?php
App::uses('Component', 'Controller');

/**
 * 通知関連関数を集約する
 */
class NotificationsComponent extends Component {

	/**
	 * お知らせを全て取得
	 * @return array
	 */
	public function getAllInPeriod(){

		//返却値を作成
		$result = array();

        //モデルをロード
        $Notification  = ClassRegistry::init('Notification');

    	//お知らせ取得（キャッシュ）
    	$notifications = $Notification->find('all',array(
    		'cache' => true,
    		'order' => 'Notification.important_flg DESC, Notification.created DESC'
    	));

    	//期間内のお知らせを抽出
		$result = $Notification->extractRecordInPeriod($notifications);

		return $result;

	}

	/**
	 * 対象のお知らせを取得
	 * @param  int   $id
	 * @return array
	 */
	public function getOne($id){

		//返却値を作成
		$result = array();

        //モデルをロード
        $Notification  = ClassRegistry::init('Notification');

    	//お知らせ取得（キャッシュ）
    	$result = $Notification->find('first',array(
    		'cache' => true,
    	));

    	var_dump($result);exit;
  		return $result;

	}

	/**
	 * 重要なお知らせのみ取得
	 * @return array
	 */
	public function getImportantInPeriod(){

		//返却値を作成
		$result = array();

        //モデルをロード
        $Notification  = ClassRegistry::init('Notification');

    	//重要なお知らせを取得（キャッシュ）
    	$notifications = $Notification->find('all',array(
    		'conditions' => array(
    			'important_flg' => 1
    		),
    		'cache' => true,
    		'order' => 'Notification.created DESC'
    	));

    	//期間内のお知らせを抽出
		$result = $Notification->extractRecordInPeriod($notifications);

		return $result;

	}

}