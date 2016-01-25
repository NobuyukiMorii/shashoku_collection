<?php
App::uses ('ErrorHandler' , 'Error' );

class AppError {

    /*
     * エラーハンドラー
     * PHPのエラーが発生した場合には、以下表示する
     */
    public static function handleError($code, $description, $file = null, $line = null, $context = null) {

        //画面表示
        echo "現在システムに障害が発生しております。ご不便をおかけしますが、しばらくお待ち下さい。";

    }

}