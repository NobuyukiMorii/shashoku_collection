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
$menu = array(
    'price' => '300',
    'order' => '/img/menu.jpeg',
    'start_date' => '1451574000',
    'end_date' => '1454166000',
    'name' => 'チキンと野菜のグラタン',
    'description' => 'ディスクリプション',
    'image' => '/img/menu.jpeg',
    'disp_date' => '1451574000' //仮
);
?>

<p class="message">クーポンを発行しました！<br/>
この画面をお店の店員さんに見せてください</p>

<div class="menuShowBox">
    <p class="rest"><? echo $rest['name'] ?></p>
    <h3><? echo $menu['name'] ?></h3>
    <img class="" src="<? echo $menu["image"] ?>" />
    <p class="bold"><? echo '価格:'.$menu['price'].'円' ?>
    <p class="dispDate"><? echo '発行日: '.date("Y/m/d H:i", $menu['disp_date']) ?></p>
    </p>
</div>

<div class="buttonBox">
<button class="cancel">レストランのページに戻る</button>
</div>