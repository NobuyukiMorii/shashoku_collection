<!-- Restaurants/detail.ctp レストラン詳細 -->
<?php 
//エラーコード（0以外の場合、いい感じにエラーメッセージを表示して頂きたいです。）
$error_code     = $response['error_code'];
//エラーメッセージ
$error_message  = $response['error_message'];
//レストラン
if(!empty($response['restaurant'])){
    $rest           = $response['restaurant'];
}
//ジャンル
if(!empty($response['genres'])){
    $genres         = $response['genres'];
}
//タグ
if(!empty($response['tags'])){
    $tags           = $response['tags'];
}
?>


<?php
// jQueryこんなところで読み込んでしもた
echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js');
// 地図用にgmaps埋め込み
echo $this->Html->script('http://maps.google.com/maps/api/js?sensor=true&.js');
echo $this->Html->script('https://rawgit.com/HPNeo/gmaps/master/gmaps.js');
?>

<!-- ヘッダーのタイトル、レストラン名にできたらおけ -->
<?php if($error_code === 0): ?>

<!-- レストラン情報 -->
<div id="restImgsBox">
<!--     <button id="prevBtn" class="is-hidden"></button>
    <button id="nextBtn"></button> -->
    <div id="restImgs">
        <?php
        $restImg_count = count($rest["photo_url"]);
        if (!empty($rest["photo_url"])) {
            foreach ($rest["photo_url"] as $restImg) {
        ?>
            <div class="restImgBox">
                <img id="" src="<?php echo $restImg ?>" />
            </div>
        <?php
            }
        }
        ?>
    </div>
</div>



<div class="titleBox titleBox-detail">
    <p class="category"><?php echo $genres[$rest["genre_id"]]; ?></p>
    <h4><?php echo $rest["name"]; ?></h4>
    <ul class="tags">
    <?php  
        if (!empty($rest["tag_ids"])) {
            foreach ($rest["tag_ids"] as $tag_id) {
                echo ' <li style="background-color:'.$tags[$tag_id]['color_code'].';">'.$tags[$tag_id]['name'].'</li>';
            }
        }
    ?>
    </ul>
    <p>ランチ営業時間:<?php ehbr($rest["lunch_time"]); ?>　定休日:<?php echo $rest["regular_holiday"]; ?></p>
    <p class="description"><?php ehbr($rest["description"]); ?></p>
</div>

<!-- メニュー -->
<div id="menusBox">
    <button id="prevBtn" class="is-hidden"></button>
    <button id="nextBtn"></button>
    <div id="menus">
        <?php
        if ($rest['coupons']['count']  > 0) {
            foreach ($rest['coupons']['list'] as $coupon) {
                $coupon["id"] = 1; // TODO: 仮
        ?>
                <div class="menuBox">
                    <img class="menuImg" src="<?php echo $coupon['set_menu']["photo_url"] ;?>" />
                    <p>クーポン利用可能期間：<?php echo date("m/d",strtotime($coupon["start_date"])).'〜'.date("m/d", strtotime($coupon["end_date"])) ?></p>
                    <p class="bold"><?php echo $coupon['price'] ?>円メニュー:<br/><?php ehbr($coupon['set_menu']['name']) ?></p>
                    <button onClick="confirmCoupon(<?php echo $coupon["id"] ?>)">このメニューのクーポンを発行する</button>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>

<h2>アクセス</h2>
<div id="map"></div>
<p class="mapLink"><a href="http://maps.google.com/maps?q=<?php echo $rest['address'] ?>">GoogleMapアプリでみる</a></p>

<h2>店舗情報</h2>
<table>
<tr><th>店舗名</th><td><?php echo $rest['name']; ?></td></tr>
<tr><th>ジャンル</th><td><?php echo $genres[$rest["genre_id"]]; ?></td></tr>
<tr><th>席数</th><td><?php echo $rest['seats_num']; ?></td></tr>
<tr><th>喫煙</th><td><?php if($rest['smoke_flg']==1) echo '可能'; else echo '不可'; ?></td></tr>
<tr><th>予約</th><td><?php if($rest['reservation_flg']==1) echo '可能'; else echo '不可'; ?></td></tr>
<tr><th>電話番号</th><td class="link"><?php echo $rest['phone_num'] ?></td></tr>
<tr><th>ランチ<br/>営業時間</th><td><?php ehbr($rest['lunch_time']) ?></td></tr>
<tr><th>定休日</th><td><?php echo $rest['regular_holiday'] ?></td></tr>
<tr><th>住所</th><td><?php echo $rest['address'] ?></td></tr>
<tr><th>店舗URL</th><td><a href="<?php echo $rest['url'] ?>" target="_blank"><?php echo $rest['url'] ?></a></td></tr>
</dl>
</table>

<?php endif; ?>

<script>
/**
* メニューのスライド
*/
var count = <?php echo $rest['coupons']['count'] ?>;
var w = screen.width;
var menus = document.getElementById('menus');
menus.style.width = w*count + 'px';
// ナンバー生成
if (count > 1) {
    var ul = $("<ul>",{id:"countBox"}).appendTo($("#menusBox"));
    for (var i=1; i<count+1; i++) {
        var li = $("<li>",{id:"num_"+i, class:(i==1)?"selected":"", text:i});
        li.appendTo(ul);
    }
} else {
    $("#nextBtn").addClass("is-hidden");
    $(".menuBox").css('margin-right','0');
}
var interval = -(w-25);
var now = 0;
var moving_flg = false;
$("#nextBtn").click(function(){
    moveNext();
});
$("#prevBtn").click(function(){
    movePrev();
});
var moveNext = function() {
    if (now >= count-1) return;
    moving_flg = true;
    now++;
    $("#menus").animate({ "margin-left": interval*now+'px' }, 800);
    setTimeout(function loop(){ doneMoving(); },800);
    // TODO: 番号の背景色変更
    if (now == count-1) $("#nextBtn").addClass("is-hidden");
    if (now > 0) $("#prevBtn").removeClass("is-hidden");
    refreshNum(now+1);
}
var movePrev = function() {
    if (now <= 0) return;
    moving_flg = true;
    now--;
    $("#menus").animate({ "margin-left": interval*now+'px' }, 800);
    setTimeout(function loop(){ doneMoving(); },800);
    // TODO: 番号の背景色変更
    if (now == 0) $("#prevBtn").addClass("is-hidden");
    if (now < count-1) $("#nextBtn").removeClass("is-hidden");
    refreshNum(now+1);
}
var refreshNum = function(num) {
    var nums = $("#countBox").children();
    if (nums && nums.length > 1) {
        var count = nums.length;
        for (var i=1; i<count+1; i++) {
            if (i==num) $("#num_"+i).addClass("selected");
            else $("#num_"+i).removeClass("selected"); 
        }
    }
}
var doneMoving = function(){
    moving_flg = false;
}
/**
 * スワイプ処理
 */
$("#menus").bind("touchstart", TouchStart);
$("#menus").bind("touchmove" , TouchMove);
// タップした位置をメモリーする
var posTapped;
function TouchStart( event ) {
    var pos = Position(event);
    posTapped = pos.x;
    // $("#menus").data("memory",pos.x);
    console.log("TouchStart pos x == "+pos.x);
}
//タップした位置からプラスかマイナスかで左右移動を判断
function TouchMove( event ) {
    if (moving_flg) return;
    var pos = Position(event); //X,Yを得る
    console.log("TouchMove pos x == "+pos.x);
    console.log("TouchMove posTapped == "+posTapped);
    if( pos.x < posTapped ){
        if ((pos.x - posTapped) < -100 ) {
            console.log("TouchMove 左!!");
            moveNext();
        }
    }else{
        if ((pos.x - posTapped) > 100 ) {
            console.log("TouchMove 右!!");
            movePrev();
        }
    }
}

/**
 * レストランのスライド(とりあえずコピーでごめんなさい!
 * 共通項みつけてリファクタリングかける 
 */
 // レストラン画像
var r_count = <?php echo count($rest["photo_url"]) ?>;
var restImgs = document.getElementById('restImgs');
restImgs.style.width = w*r_count + 'px';
// ナンバー生成
if (r_count > 1) {
    var ul = $("<ul>",{id:"r_countBox"}).appendTo($("#restImgsBox"));
    for (var i=1; i<r_count+1; i++) {
        var li = $("<li>",{id:"r_num_"+i, class:(i==1)?"selected":""});
        li.appendTo(ul);
    }
}
var r_interval = -(w);
var r_now = 0;
var r_moving_flg = false;
var r_moveNext = function() {
    if (r_now >= r_count-1) return;
    r_moving_flg = true;
    r_now++;
    $("#restImgs").animate({ "margin-left": r_interval*r_now+'px' }, 800);
    setTimeout(function loop(){ r_moving_flg=false; },800);
    r_refreshNum(r_now+1);
}
var r_movePrev = function() {
    if (r_now <= 0) return;
    r_moving_flg = true;
    r_now--;
    $("#restImgs").animate({ "margin-left": r_interval*r_now+'px' }, 800);
    setTimeout(function loop(){ r_moving_flg=false; },800);
    r_refreshNum(r_now+1);
}
var r_refreshNum = function(num) {
    var nums = $("#r_countBox").children();
    if (nums && nums.length > 1) {
        var r_count = nums.length;
        for (var i=1; i< r_count+1; i++) {
            if (i==num) $("#r_num_"+i).addClass("selected");
            else $("#r_num_"+i).removeClass("selected"); 
        }
    }
}
/**
 * スワイプ処理
 */
$("#restImgs").bind("touchstart", r_TouchStart);
$("#restImgs").bind("touchmove" , r_TouchMove);
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
    if (r_moving_flg) return;
    var pos = Position(event); //X,Yを得る
    console.log("TouchMove pos x == "+pos.x);
    console.log("TouchMove r_posTapped == "+r_posTapped);
    if( pos.x < r_posTapped ){
        if ((pos.x - r_posTapped) < -100 ) {
            console.log("TouchMove 左!!");
            r_moveNext();
        }
    }else{
        if ((pos.x - r_posTapped) > 100 ) {
            console.log("TouchMove 右!!");
            r_movePrev();
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

// 地図
var map = new GMaps({
    div: '#map',
    lat: -12.043333,
    lng: -77.028333,
    zoom: 17
});
GMaps.geocode({
    address: "<?php echo $rest['address'] ?>",
    callback: function(results, status) {
        if (status == 'OK') {
            var latlng = results[0].geometry.location;
            map.setCenter(latlng.lat(), latlng.lng());
            map.addMarker({
                lat: latlng.lat(),
                lng: latlng.lng()
            });
        }
    }
});


function confirmCoupon(coupon_id){
    // 「OK」時の処理開始 ＋ 確認ダイアログの表示
    if(window.confirm('クーポンを発行します。この操作は取り消せません。よろしいですか？')){
        location.href = "<?php echo $this->Html->url(array("controller" => "Coupons", "action" => "show")); ?>"+"?coupon_id="+coupon_id;
    } else{
        // 戻る
    }
}
</script>