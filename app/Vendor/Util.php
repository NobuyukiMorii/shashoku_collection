<?php
/**
 * アプリケーション全体で汎用的に利用出来る関数群
 * 以下、呼び出し方法
 * Util::method_name(xx, yy);
 */	
class Util {

    /**
     * オリジナルのログを出力する
     * デバッグモードの時のみ出力
     * 
     * @param  string $file
     * @param  string $method
     * @param  string $line
     * @param  string $message
     * @return null
     */ 
    public function OriginalLog($file, $method, $line, $message) {

        //debugレベルを取得
        $debug_level = Configure::read('debug');

        //開発環境の場合
        if($debug_level !== 0){

        	/* ログの内容 */
        	$sentence =	"\n\ndate:" . date('Y-m-d H:i:s'). 
        				"\nfile:"	.$file.
        				"\nmethod:"	.$method.
        				"\nline:"	.$line.
        				"\nmessage:".
        				$message;

        	/* ログを記録する */
        	$this->log($sentence, 'original');

        }

    	/* リターン */
    	return;
    }

}