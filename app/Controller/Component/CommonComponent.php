<?php
App::uses('Component', 'Controller');

/**
 * 一般的な関数を集約する
 */
class CommonComponent extends Component {

	/*
     * PCの場合には、PC用のthemeを設定する
     */
    public function setThemeForPC(){

        /* PCからのアクセスかどうかを判定する */
        $device_type = UserAgent::detectClientDeviceType();
        
        /* PCからのアクセスの場合 */
        if($device_type === 'PC') {
            /* PC用のviewを表示する */
            $this->theme = 'PC';
        }

    }

}