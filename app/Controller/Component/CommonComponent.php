<?php
App::uses('Component', 'Controller');

/**
 * 一般的な関数を集約する
 */
class CommonComponent extends Component {

    /*
     * コントローラーを読み込む
     */
    public function initialize(Controller $controller) {

      $this->Controller = $controller;

    }

    /*
     * エラーレスポンス関数
     */
    public function returnError($error_code, $error_message){

        //エラーコードを格納
        $this->Controller->view_data["error_code"]        = $error_code;

        //メッセージを格納
        $this->Controller->view_data["error_message"]     = $error_message;

    }

	/*
     * PCの場合には、PC用のthemeを設定する
     */
    public function setThemeForPC(){

        /* PCからのアクセスかどうかを判定する */
        $device_type = UserAgent::detectClientDeviceType();
        
        /* PCからのアクセスの場合 */
        if($device_type === 'PC') {
            /* PC用のviewを表示する */
            $this->Controller->theme = 'PC';
        }

    }

}