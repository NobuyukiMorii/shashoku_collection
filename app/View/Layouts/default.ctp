<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version());

// 共通パラメータ
if(!empty($response['user_data'])){
	$u    = $response['user_data'];
}
if(!empty($u['user_coupon_status'])){
	$uc   = $u['user_coupon_status'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		// echo $this->Html->css('cake.generic');

		// [Pure.css] http://purecss.io/
		echo $this->Html->css('http://yui.yahooapis.com/pure/0.6.0/pure-min.css');
		echo $this->Html->css('style');
		echo $this->Html->css('font-awesome.min');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js');
		echo $this->Html->script('common');
	?>
	<meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body id="layout">
	<div id="mask" class="is-hidden"></div>
	<div id="l-container">
		<?php // $this->element('side-menu'); 読み込み方謎なので一旦放置
			// echo "<pre>"; var_dump($u); echo "</pre>"; 
		?>
		<a href="#menu" id="menuLink" class="menu-link">
		    <!-- Hamburger icon -->
		    <span></span>
		</a>
		<div id="menu">
		    <div class="pure-menu">
		        <p class="pure-menu-heading">
			        <label><i class="fa fa-building-o"></i><?php echo $u['company']['name']?></label><br/>
			        <label><i class="fa fa-user"></i><?php echo $u['user']['name']?> さん</label>
		        </p>
		        <div id="userCoupon">
		        <p>
		        	<?php
		        	$count = $uc['count'];
		        	echo "【".(int)date('m', time())."月】";
		        	if ($count['remaining'] > 0) {
		        		echo "あと<label>".$count['remaining']."</label>回使えます!";
		        	} else {
		        		echo "あと<label>".$count['remaining']."</label>回使えます";
		        	}
		            ?>
		        </p>
		        </div>
		        <ul class="pure-menu-list">
		            <li class="pure-menu-item"><a href="<?php echo $this->Html->url(array("controller" => "Restaurants", "action" => "index")); ?>" class="pure-menu-link"><i class="fa fa-home"></i>ランチ店舗一覧</a></li>
		            <li class="pure-menu-item"><a href="<?php echo $this->Html->url(array("controller" => "Coupons", "action" => "history")); ?>" class="pure-menu-link"><i class="fa fa-history"></i>行ったお店の履歴</a></li>
		            <li class="pure-menu-item" class="menu-item-divided pure-menu-selected">
		                <a href="<?php echo $this->Html->url(array("controller" => "Notifications", "action" => "index")); ?>" class="pure-menu-link"><i class="fa fa-envelope" style="font-size:12px;"></i>運営からのお知らせ</a>
		            </li>
		            <li class="pure-menu-item"><a href="#" class="pure-menu-link"><i class="fa fa-book"></i>使い方・マニュアル</a></li>
		            <li class="pure-menu-item"><a href="#" class="pure-menu-link"><i class="fa fa-question"></i>Q&A</a></li>
		            <li class="pure-menu-item"><a href="#" class="pure-menu-link"><i class="fa fa-file-text-o"></i>利用規約</a></li>
		            <li class="pure-menu-item"><a href="<?php echo $this->Html->url(array("controller" => "Users", "action" => "detail")); ?>" class="pure-menu-link"><i class="fa fa-cog"></i>設定</a></li>
		        </ul>
		    </div>
		</div>
		<!--sidemenu ここまで-->
		<div id="l-header">

			<!-- <h1><?php echo "<img src='../img/logo.png'>" ?></h1> -->
			<h1><?php echo $this->fetch('title'); ?></h1>
		</div>
		<div id="l-main">
			<?php echo $this->Flash->render(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="l-footer">
			<p>@copyright ShashokuCollection</p>
		</div>
	</div>
	<?php 
		echo $this->Html->script('ui');
	?>
</body>
</html>
