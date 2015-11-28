<?php
App::uses('Mysql', 'Model/Datasource/Database');

class MysqlLog extends Mysql {

    /* SQLを発行する際に実行 */
    function logQuery($sql, $params = array()) {

        /* 継承元の関数を実行 */
        parent::logQuery($sql);

        /* app/Config/core.phpにConfigure::write('Cake.logQuery', 1)と記載がある場合  */
        if (Configure::read('Cake.logQuery')) {
            /* SQLログを記録 */
            $this->log($this->_queriesLog, 'sql');

        }
    }
}
?>