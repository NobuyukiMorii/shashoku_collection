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
$config['RECORD_NOT_DELETED'] 	= 0;
$config['RECORD_DELETED'] 		= 1;

/* ----------- login ----------- */
$config['LOGIN_PASSWORD_LEMGTH_MIN'] 	= 7;
$config['LOGIN_PASSWORD_LEMGTH_MAX'] 	= 14;

/* - coupon_authenticated_status_flg -- */
$config['COUPON_AUTHONICATED_STATUS_NOT_AUTHONICATED'] 				= 0;
$config['COUPON_AUTHONICATED_STATUS_NOW_AUTHONICATED'] 				= 1;
$config['COUPON_AUTHONICATED_STATUS_CONSUME_THIS_COUPON_TODAY'] 	= 2;
$config['COUPON_AUTHONICATED_STATUS_CONSUME_OTHER_COUPON_TODAY'] 	= 3;
$config['COUPON_AUTHONICATED_STATUS_MORE_THAN_MONTHLY_COUNT'] 		= 4;

/* ---------- About error code -------------------------- */
$config['ERR_CODE_NO_PARAM'] 				= 1;
$config['ERR_CODE_NO_DATA'] 				= 2;
$config['ERR_CODE_FAIL_LOGIN'] 				= 3;
$config['ERR_CODE_FAIL_SAVE'] 				= 4;
$config['ERR_CODE_NOT_LOGIN'] 				= 5;
$config['ERR_CODE_ILLEGAL_ACCESS'] 			= 6;
$config['ERR_CODE_NOT_SUITABLE_PARAM'] 		= 7;
$config['ERR_CODE_LOGIN_WRONG_ACCOUNT'] 	= 8;
$config['ERR_CODE_LOGIN_SESSION_ERROR'] 	= 9;

/* ---------- About transaction ------------------------- */
$config['TRANSACTION_DURATION'] 	= 5;
$config['TRANSACTION_CACHE_VALUE'] 	= true;