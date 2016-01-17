<?php
/**
 * ユーザーエージェントを利用した関数群
 * 以下、呼び出し方法
 * UserAgent::method_name(xx, yy);
 */	
class UserAgent {

    /*
     * PCからのアクセスを判定する
     */
    public function detectClientDeviceType(){

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