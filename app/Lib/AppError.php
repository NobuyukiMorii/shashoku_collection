<?php
App::uses ('ErrorHandler' , 'Error' );

class AppError {

    /*
     * エラーハンドラー
     * PHPのエラーが発生した場合には、以下表示する
     */
    public static function handleError($code, $description, $file = null, $line = null, $context = null) {
    	//phpの内部エラーの場合
    	//何も処理をしない
    	//500エラーとなり、ユーザーはサービスの利用が出来なくなる

        // でもこれデバッグには便利かも？
        // echo "code:".$code.":".$description."<br/>";
    }

}