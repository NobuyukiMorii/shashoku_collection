<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/* アプリケーション全体で利用出来る関数をロード */
App::uses('Util', 'Vendor');
App::uses('ArrayControl', 'Vendor');
App::uses('Arguments', 'Vendor');
App::uses('UserAgent', 'Vendor');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    /* ユーザーの情報 */
    public $user_data = array(
        'user'    => array(

        ),
        'company' => array(

        )
    );

    /* viewに送信する変数 */
    public $view_data = array(
        'error_code'    => 0,
        'error_message' => null
    );

    /* 表示jsonフラグ */
    public $view_json_flag = false;

    /* コンポーネントをロード*/
    public $components = array(
        'FindSupport',
        'Common'
    );
    
    /*
     * アクション実行前にコールされる
     */
    public function beforeFilter(){

        //Basic認証
        $this->Common->basicAuthentication();

        //PCからのアクセスの場合には専用のviewを出力する 
        $this->Common->setThemeForPC();

    }

    /*
     * アクション実行後にコールされる
     */
    public function afterFilter(){

        // jsonで返却する場合
        if ($this->view_json_flag) {

            //Json専用のviewを指定する
            $this->render('/Json/json');

        }

    }

    /*
     * レンダリングの前にコールされる
     */
    public function beforeRender() {

        // jsonで返却する場合
        if ($this->view_json_flag) {

            //UTF-8を指定
            $this->response->header(array(
                'Content-Type: application/json; charset=utf-8'
            ));

            //Jsonにエンコードして表示
            echo json_encode($this->view_data);

            exit;

        } else {
        //phpの変数で返却する場合

            $this->set('response', $this->view_data);

        }

    }

}
