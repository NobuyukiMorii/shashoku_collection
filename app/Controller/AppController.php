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
     *引数を取得する関数
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

}
