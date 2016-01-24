<!-- Restaurants/detail.ctp レストラン詳細 -->
<?php 
//エラーコード（0以外の場合、いい感じにエラーメッセージを表示して頂きたいです。）
$error_code     = $response['error_code'];
//エラーメッセージ
$error_message  = $response['error_message'];
//レストラン
$rest           = $response['restaurant'];
//ジャンル
$genres         = $response['genres'];
//タグ
$tags           = $response['tags'];
?>


<?php
// jQueryこんなところで読み込んでしもた
echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js');
// 地図用にgmaps埋め込み
echo $this->Html->script('http://maps.google.com/maps/api/js?sensor=true&.js');
echo $this->Html->script('https://rawgit.com/HPNeo/gmaps/master/gmaps.js');
?>

<!-- ヘッダーのタイトル、レストラン名にできたらおけ -->

<!-- レストラン情報 -->
<div id="restImgsBox">
    <button id="r_prevBtn" class="is-hidden"></button>
    <button id="r_nextBtn"></button>
    <div id="restImgs">
        <?php
        $restImg_count = count($rest["photo_url"]);
        if (!empty($rest["photo_url"])) {
            foreach ($rest["photo_url"] as $restImg) {
        ?>
            <div class="restImgBox">
                <img class="" src="<?php echo $restImg ?>" />
            </div>
        <?php
            }
        }
        ?>
    </div>
</div>



<div class="titleBox">
    <ul class="tags">
    <?php  
        if (empty($rest["tag_ids"])) {
            foreach ($rest["tags_id"] as $tag_id) {
                echo ' <li>'.$tags[$tag_id]["name"].'</li>';
            }
        }
    ?>
    </ul>
    <p class="category"><?php echo $genres[$rest["genre_id"]]; ?></p>
    <h4><?php echo $rest["name"]; ?></h4>
    <p>ランチ営業時間:<?php echo $rest["lunch_time"]; ?>　定休日:<?php echo $rest["regular_holiday"]; ?></p>
    <p class="description"><?php echo $rest["description"]; ?></p>
</div>

<!-- メニュー -->
<div id="menusBox">
    <button id="prevBtn" class="is-hidden"></button>
    <button id="nextBtn"></button>
    <div id="menus">
        <?php
        if ($rest['coupons']['count']  > 0) {
            foreach ($rest['coupons']['list'] as $coupon) {
        ?>
                <div class="menuBox">
                    <img class="" src="<?php echo $coupon['set_menu']["photo_url"] ;?>" />
                    <p>クーポン利用可能期間：<?php echo date("m/d",strtotime($coupon["start_date"])).'〜'.date("m/d", strtotime($coupon["end_date"])) ?></p>
                    <p class="bold"><?php echo $coupon['price'] ?>円メニュー:<?php echo $coupon['set_menu']['name'] ?></p>
                    <button><a href="<?php echo $this->Html->url(array("controller" => "Coupons", "action" => "show")); ?>">このメニューのクーポンを発行する</a></button>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>

<h2>アクセス</h2>
<div id="map">
ここにmapが入ります
</div>

<h2>店舗情報</h2>
<dl>
<dt>店舗名</dt><dd><?php echo $rest['name']; ?></dd>
<dt>ジャンル</dt><dd><?php echo $genres[$rest["genre_id"]]; ?></dd>
<dt>席数</dt><dd><?php echo $rest['seats_num'].'席'; ?></dd>
<dt>喫煙</dt><dd><?php if($rest['smoke_flg']==1) echo '可能'; else echo '不可'; ?></dd>
<dt>電話番号</dt><dd><?php echo $rest['phone_num'] ?></dd>
<dt>ランチ営業時間</dt><dd><?php echo $rest['lunch_time'] ?></dd>
<dt>定休日</dt><dd><?php echo $rest['regular_holiday'] ?></dd>
<dt>住所</dt><dd><?php echo $rest['address'] ?></dd>
<dt>店舗URL</dt><dd><a href="<?php echo $rest['url'] ?>" target="_blank"><?php echo $rest['url'] ?></a></dd>
</dl>


<script>
// メニューのスライド
var count = <?php echo $rest['menu_count'] ?>;
var w = window.innerWidth;
var menus = document.getElementById('menus');
menus.style.width = w*count + 'px';

// レストラン画像
var restImgs = document.getElementById('restImgs');
restImgs.style.width = w*count + 'px';

// ナンバー生成
if (count > 1) {
    var ul = $("<ul>",{id:"countBox"}).appendTo($("#menusBox"));
    for (var i=1; i<count+1; i++) {
        var li = $("<li>",{id:"num_"+i, class:(i==1)?"selected":"", text:i});
        li.appendTo(ul);
    }
}

var interval = -(w-25);
var now = 0;
$("#nextBtn").click(function(){
    if (now >= count-1) return;
    now++;
    $("#menus").animate({ "margin-left": interval*now+'px' }, 800 );
    // TODO: 番号の背景色変更
    if (now == count-1) $("#nextBtn").addClass("is-hidden");
    if (now > 0) $("#prevBtn").removeClass("is-hidden");
    refreshNum(now+1);
});
$("#prevBtn").click(function(){
    if (now <= 0) return;
    now--;
    $("#menus").animate({ "margin-left": interval*now+'px' }, 800 );
    // TODO: 番号の背景色変更
    if (now == 0) $("#prevBtn").addClass("is-hidden");
    if (now < count-1) $("#nextBtn").removeClass("is-hidden");
    refreshNum(now+1);
});

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
</script>