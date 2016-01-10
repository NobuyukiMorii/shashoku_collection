<!-- Restaurants/detail.ctp レストラン詳細 -->
<?
////////// ダミーデータ //////////
$rest = array(
    'id' => '0',
    'name' => 'Sancha Cafe',
    'genre_id' => '4',
    'tags_id' => ['0','1'],
    'description' => 'アクセスしやすい隠れ家カフェ！季節の野菜をたっぷり使った熱々のグラタンをご用意してお待ちしています！',
    'address' => '渋谷区',
    'phone_num' => '03-0000-0000',
    'seats_num' => '24',
    'regular_holiday' => '火曜日',
    'url' => '',
    'lunch_time' => '12:00~15:00',
    'open_time' => '1',
    'smoke_flg' => '1',
    'reservation_flg' => '1',
    'smoke_flg' => '1',
    'image' => '/img/rest01.jpg',
    'menu' => 'チキンと野菜のグラタン', // main_menu? 配列にする?
    'menu_count' => '3' //仮: menuの数
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

<!-- ヘッダーのタイトル、レストラン名にできたらおけ -->

<!-- レストラン情報 -->
<img class="" src="<? echo $rest["image"] ?>" />
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
<div class="menus">
    <!-- スライド -->
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
