<?php
class NotificationsController extends AppController {

	//コンポーネントをロード
    public $components = array(
        'Notifications',
    );

    public function index() {

    	//お知らせ取得
    	$this->view_data['Notifications'] = $this->Notifications->getAll();

    	//値を返却
    	return $this->view_data;

    }

    public function detail($notification_id=null) {

        //----------------------------------------
        //お知らせidを取得
        //----------------------------------------
        if(empty($notification_id)){
    		$notification_id = Arguments::getArguments('notification_id');
    	}
    	//お知らせidが設定されなかった場合
    	if(is_null($notification_id) || !is_numeric($notification_id)){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_PARAM'), __('対象のお知らせが取得出来ません。'));	
			return;
    	}

    	//お知らせ取得
		$this->view_data['Notification'] = $this->Notifications->getOne($id);

		//対象のお知らせがない場合
		if(empty($this->view_data['Notification'])){
			$this->Common->returnError(Configure::read('ERR_CODE_NO_DATA'), __('対象のお知らせがありません。'));	
			return;
		}

    	//値を返却
    	return $this->view_data;

    }

}