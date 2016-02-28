<pre>
<?php

// var_dump($response);

if(!empty($response['coupon']['restaurant'])){
    $rest           = $response['coupon']['restaurant'];
}
if(!empty($response['coupon']['coupon'])){
    $coupon         = $response['coupon']['coupon'];
    $menu           = $response['coupon']['coupon']['set_menu'];
} 
?>
</pre>

<div id="signUp" class="is-hidden">
<p>右にスライドして認証してください<br/>
※認証後は取消できません。</p>
<div class="slider">
<i id="target" class="fa fa-chevron-circle-right target"></i>
<p>>　>　>　>　></p>
<i class="fa fa-chevron-circle-right goal"></i>
</div>
<p id="success" class="is-hidden"><i class="fa fa-check-circle-o"></i>認証成功！</p>
<button class="cancel" onClick="signUpCancel()"><i class="fa fa-times-circle"></i>キャンセル</button>
</div>

<?php if ($coupon['is_authenticated_today']) { ?>
<p class="message">クーポンを発行しました！<br/>
この画面をお店の店員さんに見せてください</p>
<?php } else {?>
<p class="message">このクーポンは認証済みです。<br/>
ご利用いただきありがとうございます！</p>
<?php } ?>

<div class="menuShowBox">
    <p class="rest"><?php ehbr($rest['name']) ?></p>
    <h3><?php ehbr($menu['name']) ?></h3>
    <img class="" src="<?php echo $menu["photo_url"] ?>" />
    <p class="bold"><?php echo '価格:'.$coupon['price'].'円' ?>
    <?php if ($coupon['is_authenticated_today']) { ?>
    <p class="dispDate"><?php echo '発行日時: '.$response["coupon"]["datetime"]; ?></p>
    </p>
    <?php } ?>
    <?php if ($coupon['is_authenticated_today']) { ?>
        <button class="emergency" onClick="signUpCall()">認証する<br/><label>※必ず店舗の方に押してもらってください</label></button>
    <?php } else { ?>
        <button class="cancel">クーポンは認証済みです</button>
    <?php } ?>
</div>

<div class="buttonBox">
<button class="cancel" onClick="history.back()">レストランのページに戻る</button>
</div>

<form name="is_coupons_consumption" method="POST" action="">
<input type=hidden name="is_coupons_consumption" value=true >
</form>


<script>
function signUpInit() {
    $("#signUp").bind("touchstart", r_TouchStart);
    $("#signUp").bind("touchmove" , r_TouchMove);
    $("#signUp").bind("touchend" , r_TouchCancel);
    if (!$("#mask_back") || !$("#mask_back").length > 0) {
        var mask = $("<div id='mask_back'>");
        // mask.id = "mask_back";
        $("#layout").append(mask);
        // $("#layout").insertBefore(mask, $("#layout").firstChild);
    } else {
        $("#mask_back").removeClass("is-hidden");
    }
    $("#layout").addClass("is-fixed");
}
function signUpCall() {
    signUpInit();
    $("#signUp").removeClass("is-hidden");
}
function signUpDone() {
    $("#success").removeClass("is-hidden");
    setTimeout( function () {
        // POST送信
        document.is_coupons_consumption.submit();
        // Show読み込み直す
        // signUpCancel();
    } , 2000 );
}
function signUpCancel() {
    $("#signUp").addClass("is-hidden");
    $("#mask_back").addClass("is-hidden");
    $("#layout").removeClass("is-fixed");
}
// タップした位置をメモリーする
var r_posTapped;
function r_TouchStart( event ) {
    var pos = Position(event);
    r_posTapped = pos.x;
    // $("#restImgs").data("memory",pos.x);
    console.log("TouchStart pos x == "+pos.x);
}
var moving;
//タップした位置からプラスかマイナスかで左右移動を判断
function r_TouchMove( event ) {
    var pos = Position(event); //X,Yを得る
    console.log("TouchMove pos x == "+pos.x);
    console.log("TouchMove r_posTapped == "+r_posTapped);
    moving = pos.x - r_posTapped;
    if (moving > 0 && moving < 200) $("#target").css("left", moving+5+"px");
    if (moving > 190) {
        console.log("認証OK!");
        // 色変える
        if (!$("#target").hasClass("is-ok")) {
            $("#target").addClass("is-ok");
        }
    }
    if (moving < 190) {
        // 色戻す
        $("#target").removeClass("is-ok");
    }

}
function r_TouchCancel( event ) {
    if (moving > 190) {
        signUpDone();
    } else {
        var reset = setInterval(function(){
            $("#target").css("left", moving+5+"px");
            moving --;
            if (moving < 0) {
                $("#target").css("left", "5px")
                clearInterval(reset);
            }
        }, 0.1);
    }
}
/*
 * 現在位置を得る
 */
function Position   (e){
    var x   = e.originalEvent.touches[0].pageX;
    var y   = e.originalEvent.touches[0].pageY;
    x = Math.floor(x);
    y = Math.floor(y);
    var pos = {'x':x , 'y':y};
    return pos;
};
</script>