<!-- Restaurants/index.ctp トップページ レストラン一覧 -->

<!-- お知らせ -->
<ul class="information small">
    <?
    ////////// ダミーデータ //////////
    $notices = array(
        array(
            'id' => '0',
            'title' => '【重要】12月から○○が変更になります',
            'comment' => '【重要】12月から○○が変更になりますのコメントコメントコメントコメントコメントコメントコメントコメント',
            'restaurant_list_banner_flg' => '1',
            'important_flg' => '1',
            'start_date' => '1451574000',
            'close_date' => '1452351600'
        ),
        array(
            'id' => '1',
            'title' => '○○機能が追加されました',
            'comment' => '【重要】12月から○○が変更になりますのコメントコメントコメントコメントコメントコメントコメントコメント',
            'restaurant_list_banner_flg' => '1',
            'important_flg' => '0',
            'start_date' => '1451574000',
            'close_date' => '1452351600'
        )
    );
    ?>

    <?
    if (isset($notices) && count($notices) > 0) {
        foreach ($notices as $notice) {
            echo '<a href="/notice/'.$notice["id"].'" ';
            if($notice["important_flg"]) {echo 'class="is-important">'; }
            else { echo '>'; }
            echo '<li><label class="date">'.date("m/d",$notice["start_date"]).'</label> ';
            echo $notice["title"].'</li></a>';
        }
    }
    ?>
</ul>

<!-- 一覧 -->
<div class="boxList 3col">
    <?
    ////////// ダミーデータ //////////
    $restaurants = array(
        array(
            'id' => '0',
            'name' => 'Sancha Cafe',
            'genre_id' => '4',
            'tags_id' => ['0','1'],
            'address' => '渋谷区',
            'phone_num' => '03-0000-0000',
            'seats_num' => '24',
            'regular_holiday' => '火曜日',
            'url' => '',
            'lunch_time' => '1',
            'open_time' => '1',
            'smoke_flg' => '1',
            'reservation_flg' => '1',
            'smoke_flg' => '1',
            'image' => '/img/rest01.jpg',
            'menu' => 'チキンと野菜のグラタン', // main_menu? 配列にする?
            'menu_count' => '3' //仮: menuの数
        ),
        array(
            'id' => '0',
            'name' => 'Sancha Cafe',
            'genre_id' => '1',
            'tags_id' => ['1'],
            'address' => '渋谷区',
            'phone_num' => '03-0000-0000',
            'seats_num' => '24',
            'regular_holiday' => '火曜日',
            'url' => '',
            'lunch_time' => '1',
            'open_time' => '1',
            'smoke_flg' => '1',
            'reservation_flg' => '1',
            'smoke_flg' => '1',
            'image' => '/img/rest01.jpg',
            'menu' => 'そばつゆ',
            'menu_count' => '2' //仮: menuの数
        ),
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
    ?>

    <?
    if (isset($restaurants) && count($restaurants) > 0) {
        foreach ($restaurants as $rest) {
    ?>
            <a href="/Restaurants/detail/<? $rest['id'] ?>"><div class="img ratioFixed" style="background-image:url('<? echo $rest["image"]; ?>')">
                <div class="titleBox titleBox-top">
                    <!-- <div class="map">map</div> -->
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
                    <p class="menu">300円メニュー:<? echo $rest["menu"]; ?><label <? if((int)$rest["menu_count"]<=1) echo 'class="is-hidden"' ?>>..他<?echo $rest["menu_count"]-1?>つ</label></p>
                </div>
            </div></a>
    <?
        }
    }
    ?>
</div>