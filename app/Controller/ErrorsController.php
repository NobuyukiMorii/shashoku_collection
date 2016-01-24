<?php
  class ErrorsController extends AppController {

  	/*
  	 * 404エラーの場合
  	 */
    public function error404() {

    	//デバッグレベルを取得
    	$debug_level = Configure::read('debug');

    	//デバッグレベルが0であれば、
    	if($debug_level == 0){

    		//リダイレクト
    		$this->redirect(array('controller'=>'Restaurants', 'action'=>'index'));
        return;

    	} 

    }

  }
?>