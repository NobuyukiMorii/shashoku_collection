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

	public $components = array('DebugKit.Toolbar');

    /*
     * アクション実行前にコールされる
     */
    public function beforeFilter(){

        /* PCからのアクセスの場合には専用のviewを出力する */
        $this->_setThemeForPC();

    }

    /* 
     * 引数を取得する関数
     */
    protected function _getArguments(){

        /* 返却値を設定する */
        $result = array();

        /* CakePHPのactionの引数を取得する */
        $result['ACTION_ARGS'] = func_get_args();
        if(empty($result['ACTION_ARGS'])){
            unset($result['ACTION_ARGS']);
        }

        /* $_POSTのデータを取得する */
        $result['POST'] = $this->request->data;
        if(empty($result['POST'])){
            unset($result['POST']);
        }

        /* $_GETのデータを取得する */
        $result['GET'] = $this->request['url'];
        if(empty($result['GET'])){
            unset($result['GET']);
        }

        return $result;

    }

    /*
     * PCの場合には、PC用のthemeを設定する
     */
    protected function _setThemeForPC(){

        /* PCからのアクセスかどうかを判定する */
        $device_type = $this->_detectClientDeviceType();
        
        /* PCからのアクセスの場合 */
        if($device_type === 'PC') {
            /* PC用のviewを表示する */
            $this->theme = 'PC';
        }

    }

    /*
     * PCからのアクセスを判定する
     */
    protected function _detectClientDeviceType(){

        /* 返却値の初期値を設定する */
        $device_type = 'PC';

        /* ユーザーエージェントを取得する */
        $ua = env('HTTP_USER_AGENT');

        if(strpos($ua,'iPhone')){
            $device_type = 'iPhone';
        } else if (strpos($ua,'iPod')){
            $device_type = 'iPad';
        } else if (strpos($ua,'iPod')){
            $device_type = 'iPod';
        } else if (strpos($ua,'Android')){
            $device_type = 'Android';
        } else if (strpos($ua,'DoCoMo')){
            $device_type = 'DoCoMo';
        } else if (strpos($ua,'UP\.Browser')){
            $device_type = 'UP\.Browser';
        } else if (strpos($ua,'J-PHONE')){
            $device_type = 'J-PHONE';
        } else if (strpos($ua,'Vodafone')){
            $device_type = 'Vodafone';
        } else if (strpos($ua,'SoftBank')){
            $device_type = 'SoftBank';
        } else if(strpos($ua,'Googlebot-Mobile')){
            $device_type = 'Googlebot';
        } 

        return $device_type;

    }

}
