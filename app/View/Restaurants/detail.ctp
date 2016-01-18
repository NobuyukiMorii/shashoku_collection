<!-- Restaurants/detail.ctp レストラン詳細 -->
<?
////////// ダミーデータ //////////
$rest = array(
    'id' => '0',
    'name' => 'Sancha Cafe',
    'genre_id' => '4',
    'tags_id' => ['0','1'],
    'description' => 'アクセスしやすい隠れ家カフェ！季節の野菜をたっぷり使った熱々のグラタンをご用意してお待ちしています！',
    'address' => '世田谷区上馬1-19-16',
    'phone_num' => '03-0000-0000',
    'seats_num' => '24',
    'regular_holiday' => '火曜日',
    'url' => '',
    'lunch_time' => '12:00~15:00',
    'open_time' => '1',
    'smoke_flg' => '1',
    'reservation_flg' => '1',
    'smoke_flg' => '1',
    'image' => array('/img/rest01.jpg','/img/rest01.jpg'),
    'menu' => 'チキンと野菜のグラタン', // main_menu? 配列にする?
    'menu_count' => '2' //仮: menuの数
);
$tags = array(
    '0' => '栄養バランスバッチリ!',
    '1' => '低カロリー'
);
$genres = array(
    '0' => '和食',
    '1' => '洋食',
    '2' => '中華',
    '3' => 'ビュッフェ',
    '4' => 'カフェランチ'
);
$menus = array(
    array(
        'price' => '300',
        'order' => '/img/menu.jpeg',
        'start_date' => '1451574000',
        'end_date' => '1454166000',
        'name' => 'チキンと野菜のグラタン',
        'description' => 'ディスクリプション',
        'image' => '/img/menu.jpeg'
    ),
    array(
        'price' => '300',
        'order' => '/img/menu.jpeg',
        'start_date' => '1451574000',
        'end_date' => '1454166000',
        'name' => 'いちごパイ',
        'description' => 'ディスクリプション',
        'image' => '/img/menu.jpeg'
    )
);
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
        <?
        $restImg_count = count($rest["image"]);
        if (isset($rest["image"]) && $restImg_count  > 0) {
            foreach ($rest["image"] as $restImg) {
        ?>
            <div class="restImgBox">
                <img class="" src="<? echo $restImg ?>" />
            </div>
        <?
            }
        }
        ?>
    </div>
</div>



<div class="titleBox">
    <ul class="tags">
    <?  
        if (isset($rest["tags_id"]) && count($rest["tags_id"]) > 0) {
            foreach ($rest["tags_id"] as $tag_id) {
                echo ' <li>'.$tags[$tag_id].'</li>';
            }
        }
    ?>
    </ul>
    <p class="category"><? echo $genres[$rest["genre_id"]]; ?></p>
    <h4><? echo $rest["name"]; ?></h4>
    <p>ランチ営業時間:<? echo $rest["lunch_time"]; ?>　定休日:<? echo $rest["regular_holiday"]; ?></p>
    <p class="description"><? echo $rest["description"]; ?></p>
</div>

<!-- メニュー -->
<div id="menusBox">
    <button id="prevBtn" class="is-hidden"></button>
    <button id="nextBtn"></button>
    <div id="menus">
        <?
        $menu_count = count($menus);
        if (isset($menus) && $menu_count  > 0) {
            foreach ($menus as $menu) {
        ?>
                <div class="menuBox">
                    <img class="" src="<? echo $menu["image"] ?>" />
                    <p>クーポン利用可能期間：<? echo date("m/d",$menu["start_date"]).'〜'.date("m/d",$menu["end_date"]) ?></p>
                    <p class="bold"><? echo $menu['price'] ?>円メニュー:<? echo $menu['name'] ?></p>
                    <button>このメニューのクーポンを発行する</button>
                </div>
        <?
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
<dt>店舗名</dt><dd><? echo $rest['name']; ?></dd>
<dt>ジャンル</dt><dd><? echo $genres[$rest["genre_id"]]; ?></dd>
<dt>席数</dt><dd><? echo $rest['seats_num'].'席'; ?></dd>
<dt>喫煙</dt><dd><? if($rest['smoke_flg']==1) echo '可能'; else echo '不可'; ?></dd>
<dt>電話番号</dt><dd><? echo $rest['phone_num'] ?></dd>
<dt>ランチ営業時間</dt><dd><? echo $rest['lunch_time'] ?></dd>
<dt>定休日</dt><dd><? echo $rest['regular_holiday'] ?></dd>
<dt>住所</dt><dd><? echo $rest['address'] ?></dd>
<dt>店舗URL</dt><dd><? echo $rest['name'] ?></dd>
</dl>


<script>
// メニューのスライド
var count = <? echo $rest['menu_count'] ?>;
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
    address: "<? echo $rest['address'] ?>",
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