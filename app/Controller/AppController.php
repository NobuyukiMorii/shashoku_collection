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

//ユーティリティーをロード
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/* アプリケーション全体で利用出来る関数をロード */
App::uses('Util', 'Vendor');
App::uses('ArrayControl',   'Vendor');
App::uses('Arguments',      'Vendor');
App::uses('UserAgent',      'Vendor');
App::uses('Log',            'Vendor');
App::uses('DateControl',    'Vendor');

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

    /* viewに送信する変数 */
    public $view_data = array(
        'error_code' => 0,
        'error_message' => "",
        'this_month' => "",
        'user_data' => array(
            'user' => array(
                'id' => 0,
                'name' => "",
                'email' => ""
            ),
            'company' => array(
                'name' => ""
            ),
            'user_coupon_status' => array(
                'count' => array(
                    'monthly' => 0,
                    'consumption' => 0,
                    'remaining' => 0
                ),
                'availability' => array(
                    'is_available' => false,
                    'less_than_monthly_count' => false
                ),
                'consumed' => array(
                    'today' => true
                )
            ),
        )
    );

    /* 表示jsonフラグ */
    public $view_json_flag = false;

    /* コンポーネントをロード*/
    public $components = array(
        'FindSupport',
        'Common',
        'Session',
        'Users',
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'fields' => array(
                        'username' => 'email'
                    ),
                    'passwordHasher' => array(
                            'className' => 'Simple',
                            'hashType' => 'sha1',
                    ),
                ),
            ),
        )
    );
    
    /**
     * アクション実行前にコールされる
     * @return void
     */
    public function beforeFilter(){

        /* 
         * リクエスト毎にCookieが再作成される
         * sessionを1ヶ月間とするため
         * （参考サイト）
         * http://artisanedge.jp/blog/2012/11/21/223145.html
         */
        CakeSession::$requestCountdown = 1;

        //今月ログインしたかどうか
        $is_this_month_login = $this->Users->checkThisMonthLogin();
        //今月ログインしていない場合
        if($is_this_month_login === false){
            //認証のSessionを削除。強制的にログアウトされる。
            $this->Session->delete('Auth');
        }

        //Basic認証
        $this->Common->basicAuthentication();

        //PCからのアクセスの場合には専用のviewを出力する 
        $this->Common->setThemeForPC();

    }

    /**
     * アクション実行後にコールされる
     * @return void
     */
    public function afterFilter(){

        // jsonで返却する場合
        if ($this->view_json_flag) {

            //Json専用のviewを指定する
            $this->render('/Json/json');

        }

    }

    /**
     * レンダリングの前にコールされる
     * @return void
     */
    public function beforeRender() {

        //ユーザーデータをviewに渡す
        $this->Users->setUserDataForView();

        //viewにレスポンスを渡す
        $this->Common->setDefaultResponse();

    }

}
