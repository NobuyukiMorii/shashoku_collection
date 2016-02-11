<?php
if(!empty($response['coupon']['restaurant'])){
    $rest           = $response['coupon']['restaurant'];
}
if(!empty($response['coupon']['coupon'])){
    $coupon         = $response['coupon']['coupon'];
    $menu           = $response['coupon']['coupon']['set_menu'];
} 
?>

<p class="message">クーポンを発行しました！<br/>
この画面をお店の店員さんに見せてください</p>

<div class="menuShowBox">
    <p class="rest"><?php echo $rest['name'] ?></p>
    <h3><?php echo $menu['name'] ?></h3>
    <img class="" src="<?php echo $menu["photo_url"] ?>" />
    <p class="bold"><?php echo '価格:'.$coupon['price'].'円' ?>
    <p class="dispDate"><?php echo '発行日: '.date("Y/m/d H:i"/*, $menu['disp_date']*/) ?></p>
    </p>
</div>

<div class="buttonBox">
<button class="cancel">レストランのページに戻る</button>
</div>