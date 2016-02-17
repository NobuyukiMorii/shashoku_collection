<?php
if(!empty($response['coupon']['restaurant'])){
    $rest           = $response['coupon']['restaurant'];
}
if(!empty($response['coupon']['coupon'])){
    $coupon         = $response['coupon']['coupon'];
    $menu           = $response['coupon']['coupon']['set_menu'];
} 
?>

<div id="signUp" class="is-hidden">
<p>認証ジェスチャーを下のエリアにかいてください</p>
<p id="success" class="is-hidden">認証成功！</p>
<button class="cancel" onClick="signUpCancel()">キャンセル</button>
</div>

<p class="message">クーポンを発行しました！<br/>
この画面をお店の店員さんに見せてください</p>

<div class="menuShowBox">
    <p class="rest"><?php echo $rest['name'] ?></p>
    <h3><?php echo $menu['name'] ?></h3>
    <img class="" src="<?php echo $menu["photo_url"] ?>" />
    <p class="bold"><?php echo '価格:'.$coupon['price'].'円' ?>
    <p class="dispDate"><?php echo '発行日時: '.date("Y/m/d H:i"/*, $menu['disp_date']*/) ?></p>
    </p>
    <button class="emergency" onClick="signUpCall()">認証ボタン<br/>※必ず店舗の方に押してもらってください</button>
</div>

<div class="buttonBox">
<button class="cancel">レストランのページに戻る</button>
</div>

<script>
function signUpInit() {
    $("#signUp").bind("touchstart", r_TouchStart);
    $("#signUp").bind("touchmove" , r_TouchMove);
}
function signUpCall() {
    signUpInit();
    $("#signUp").removeClass("is-hidden");
}
function signUpDone() {
    $("#success").removeClass("is-hidden");
    setTimeout( function () {
        $("#signUp").addClass("is-hidden");
    } , 1000 );
}
function signUpCancel() {
    $("#signUp").addClass("is-hidden");
}
// タップした位置をメモリーする
var r_posTapped;
function r_TouchStart( event ) {
    var pos = Position(event);
    r_posTapped = pos.x;
    // $("#restImgs").data("memory",pos.x);
    console.log("TouchStart pos x == "+pos.x);
}
//タップした位置からプラスかマイナスかで左右移動を判断
function r_TouchMove( event ) {
    var pos = Position(event); //X,Yを得る
    console.log("TouchMove pos x == "+pos.x);
    console.log("TouchMove r_posTapped == "+r_posTapped);
    if( pos.x < r_posTapped ){
        if ((pos.x - r_posTapped) < -100 ) {
            console.log("TouchMove 左!!");
            // r_moveNext();
        }
    }else{
        if ((pos.x - r_posTapped) > 200 ) {
            console.log("TouchMove 右!!");
            signUpDone();
        }
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
}

</script>