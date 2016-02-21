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

        //Ajaxの場合
        if ($this->Controller->request->is('ajax')) {
            //jsonを利用
            $this->Controller->view_json_flag = true;
        }

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

	/**
     * PCの場合には、PC用のthemeを設定する
     * @return void
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

    /**
     * 現在のページ数を取得
     * @return void
     */
    public function getCurrentPage(){

        //ページを取得
        if(isset($this->Controller->params['named']['page'])){
            //ページングの利用をon
            $this->Controller->paging['is_use']       = true;
            //現在のページを取得
            $this->Controller->paging['current_page'] = $this->Controller->params['named']['page'];
        } else {

            $this->Controller->paging['current_page'] = 1;    
        }

    }

    /**
     * Pagingをviewに送る
     * @return void
     */
    public function setPagingForView(){

        //ページ情報を送信する
        if($this->Controller->paging['is_use'] === true){

            //総ページ数と現在のページ数が一致していたら
            if($this->Controller->paging['total_pages'] == $this->Controller->paging['current_page']){

                //最終ページをtrueとする
                $this->Controller->paging['is_end_page'] = true;

            }

            //ページ情報を追加
            $this->Controller->view_data['paging'] = $this->Controller->paging;

        } else {
            //ページ情報を除去
            unset($this->Controller->view_data['paging']);
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