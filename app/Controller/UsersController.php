<?php
class UsersController extends AppController {

    /* コンポーネントをロード*/
    public $components = array(
        'Users',
        'Passwords'
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

            //Authセッションを削除（初期化）
            $this->Session->delete('Auth');

            //ログイン
            if ($this->Auth->login()) {

                //Authをセット
                $user_data = $this->Users->setAuthSession($this->Auth->user('id'));

                //ユーザーデータがない場合
                if(empty($user_data)){
                    $this->Common->returnError(Configure::read('ERR_CODE_NO_DATA'), __('ユーザーデータが取得出来ません。'));

                    //ログアウト
                    $this->Auth->logout();

                    //フォームデータの送信
                    $this->view_data['form']['email']       = $this->request->data['User']['email'];
                    $this->view_data['form']['password']    = $this->request->data['User']['password'];

                }

                //ログイン後ページ遷移
                $this->redirect(array('controller' => 'Restaurants', 'action' => 'index'));

            } else {

                //不正なアカウントの場合
                $this->Common->returnError(Configure::read('ERR_CODE_LOGIN_WRONG_ACCOUNT'), __('ユーザー名とパスワードが一致しません。'));

                //フォームデータの送信
                $this->view_data['form']['email']       = $this->request->data['User']['email'];
                $this->view_data['form']['password']    = $this->request->data['User']['password'];

            }
        }

    }

    /**
     * ログアウト
     * @return void
     */
    public function logout() {

        //ログアウト
        $this->Auth->logout();

        //ログイン画面遷移
        $this->redirect(array('controller' => 'Users', 'action' => 'login'));

        return;

    }

    /**
     * ユーザー情報表示
     * @return array
     */
    public function detail() {

        //ユーザー情報を送信
        $this->view_data['user_detail'] = $this->Session->read('Auth');

        return $this->view_data;

    }

    /**
     * パスワード変更
     * @return void
     */
    public function password($password=null, $password_confirm=null) {

        //返却値を設定
        $result = array();

        //POSTされた場合
        if ($this->request->is('post')) {

            //----------------------------------------
            //パスワード取得
            //----------------------------------------
            if(empty($password)){
                $password = Arguments::getArguments('password');
            }
            if(empty($password_confirm)){
                $password_confirm = Arguments::getArguments('password_confirm');
            }

            //----------------------------------------
            //バリデーション
            //----------------------------------------
            //バリデーション実行
            $validation_result = $this->Passwords->updateValidation($password, $password_confirm);
            //エラー返却
            if($validation_result['error_code'] !== 0){
                //エラーコードを返却
                $this->Common->returnError($validation_result['error_code'], $validation_result['error_message']);
                return;
            }

            //----------------------------------------
            //ハッシュ化
            //----------------------------------------
            $password = $this->Passwords->encrypt($password);

            //----------------------------------------
            //パスワード更新
            //----------------------------------------
            $result = $this->Passwords->update($this->Auth->user('id'), $password);
            if($result === false){
                //エラーメッセージを返却
                $this->Common->returnError(Configure::read('ERR_CODE_FAIL_SAVE'), __('パスワードの更新に失敗しました。'));   
                return;
            }

            //----------------------------------------
            //リダイレクト
            //----------------------------------------
            //リダイレクト後のフラッシュメッセージを登録
            $this->Flash->set(__('パスワードを変更しました'));

            //リダイレクト
            $this->redirect(array('controller' => 'Users', 'action' => 'detail'));

        }

    }

}