<?php
class UsersController extends AppController {

    /* コンポーネントをロード*/
    public $components = array(
        'Users'
    );

    public function beforeFilter() {

        parent::beforeFilter();

        $this->Auth->allow('login', 'logout');

    }

    /**
     * ログイン
     * @return void
     */
    public function login() {

        $this->layout = "sample";

        //POSTされた場合
        if ($this->request->is('post')) {

            //ログイン
            if ($this->Auth->login()) {

                //Authをセット
                $user_data = $this->Users->setAuthSession($this->Auth->user('id'));

                //ユーザーデータがない場合
                if(empty($user_data)){
                    $this->Common->returnError(Configure::read('ERR_CODE_NO_DATA'), __('ユーザーデータが取得出来ません。'));

                    //ログアウト
                    $this->Auth->logout();

                    //ログイン画面遷移
                    $this->redirect(array('controller' => 'Users', 'action' => 'login'));
                    return;

                }
                
                //ログイン後ページ遷移
                $this->redirect(array('controller' => 'Restaurants', 'action' => 'index'));

            } else {

                //ログイン画面遷移
                $this->redirect(array('controller' => 'Users', 'action' => 'login'));

            }
        }

    }

    public function logout() {
        $this->Auth->logout();
    }

    public function detail() {

    }

    public function password() {

    }

    public function edit() {

    }

}