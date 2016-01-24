<?php
/* We can define constant various in this file.
 *
 * [example in define.php]
 * $config['fruit']='apple';
 *
 * We can use constant various like below
 * [example in another files]
 * $fruit = Configure::read('fruit');
 */

/* ---------- About table ------------------------------ */

/* ---------- All table ---------------------- */

/* ---------- del_flg ---------- */
$config['RECORD_NOT_DELETED'] = "0";
$config['RECORD_DELETED'] = "1";


/* ---------- About error code -------------------------- */
$config['ERR_CODE_NO_PARAM'] 	= "1";
$config['ERR_CODE_NO_DATA'] 	= "2";