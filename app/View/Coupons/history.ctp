<div class="boxList">
    <?
    ////////// ダミーデータ //////////
    $histories = array(
        array(
            'id' => '0', //レストランid
            'name' => 'Sancha Cafe',
            // 'genre_id' => '4',
            // 'tags_id' => ['0','1'],
            'address' => '渋谷区',
            // 'phone_num' => '03-0000-0000',
            // 'seats_num' => '24',
            // 'regular_holiday' => '火曜日',
            // 'url' => '',
            // 'lunch_time' => '1',
            // 'open_time' => '1',
            // 'smoke_flg' => '1',
            // 'reservation_flg' => '1',
            // 'smoke_flg' => '1',
            'image' => '/img/rest01.jpg',
            // ここからメニューテーブル?
            'menu' => 'チキンと野菜のグラタン', // main_menu? 配列にする?
            'price' => '300',
            'disp_date' => '1451574000'
        ),
        array(
            'id' => '0', //レストランid
            'name' => 'Sancha Cafe',
            'address' => '渋谷区',
            'image' => '/img/rest01.jpg',
            // ここからメニューテーブル?
            'menu' => 'チキンと野菜のグラタン', // main_menu? 配列にする?
            'price' => '300',
            'disp_date' => '1451574000'
        ),
    );
    ?>

<h2>12月</h2>

    <?
    if (isset($histories) && count($histories) > 0) {
        foreach ($histories as $history) {
    ?>
            <p class="pdlr-10"><? echo date("Y/m/d", $history['disp_date']) ?></p> 
            <a href="/Restaurants/detail/<? $history['id'] ?>"><div class="img ratioFixed history" style="background-image:url('<? echo $history["image"]; ?>')">
                <div class="titleBox">
                    <h4><? echo $history["name"]; ?></h4>
                    <p class="menu">300円メニュー:<? echo $history["menu"]; ?></p>
                </div>
            </div></a>
    <?
        }
    }
    ?>
</div>