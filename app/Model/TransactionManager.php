<?php
App::uses('AppModel', 'Model');

class TransactionManager extends AppModel {

    public $useTable = false;

    /**
     * @param  object $_dataSource
     * @return void
     */
    public function begin(){

        $dataSource = $this->getDataSource();

        $dataSource->begin($this);

        return $dataSource;

    }

    /**
     * @param  object $_dataSource
     * @return void
     */
    public function commit($_dataSource){

        $_dataSource->commit();

    }

    /**
     * @param  object $_dataSource
     * @return void
     */
    public function rollback($_dataSource){

        $_dataSource->rollback();
        
    }

    /**
     * @param  object $_dataSource
     * @return void
     */
    public function getUserCachePath($folder_path, $func_name=null){

        //返却値を設定
        $result = "";

        //引数がない場合
        if(empty($folder_path)){
            return $result;
        }

        //フォルダ名を格納
        $result = $folder_path;

        //関数名がない場合
        if($func_name === null){
            return $result;
        }

        $result = $folder_path.$func_name.'/';

        return $result;
        
    }



}