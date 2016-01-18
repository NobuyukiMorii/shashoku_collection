<?php
/**
 * パラメーター関連の関数群
 * 以下、呼び出し方法
 * Arguments::method_name(xx, yy);
 */	
class Arguments {

    /**
     * 引数を取得する
     * @param  mixed param
     * @return null
     */ 
    public function getArguments($param){

        //返却値を設定
        $result = null;

        //引数がなければ
        if(is_null($param)){
            return $result;
        }

        //POSTを取得する
        $result = $this->request->data($param);

        //POSTがなければ
        if(is_null($result)) {

            //debugレベルを取得
            $debug_level = Configure::read('debug');

            //開発環境の場合
            if($debug_level !== 0){

                //GETを格納する
                $result = $this->request->query($param);

            } 

        } 

        return $result;

    }

}