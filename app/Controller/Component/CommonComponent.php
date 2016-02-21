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

    /**
     * viewにレスポンスを渡す
     * @return void
     */
    public function setDefaultResponse(){

        // jsonで返却する場合
        if ($this->Controller->view_json_flag) {

            //UTF-8を指定
            $this->Controller->response->header(array(
                'Content-Type: application/json; charset=utf-8'
            ));

            //Jsonにエンコードして表示
            echo json_encode($this->Controller->view_data);

            exit;

        } else {
        //phpの変数で返却する場合

            $this->Controller->set('response', $this->Controller->view_data);

        }

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

    /*
     * Basic認証のコンポーネント
     */
    public function basicAuthentication(){

        //Basic認証
        $this->Controller->autoRender = false;


        $loginId = 'shashoku';
        $loginPassword = 'shashoku'; 

        if (!isset($_SERVER['PHP_AUTH_USER'])) {

            header('WWW-Authenticate: Basic realm="Please enter your ID and password"');
            header('HTTP/1.0 401 Unauthorized');
            die("id / password Required");

        } else {

            if ($_SERVER['PHP_AUTH_USER'] != $loginId || $_SERVER['PHP_AUTH_PW'] != $loginPassword) {
                
                header('WWW-Authenticate: Basic realm="Please enter your ID and password"');
                header('HTTP/1.0 401 Unauthorized');
                die("Invalid id / password combination.  Please try again");
            }
        }
        $this->Controller->autoRender = true;

    }

}