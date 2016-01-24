<!-- Restaurants/index.ctp トップページ レストラン一覧 -->
<?php 
//エラーコード（0以外の場合、いい感じにエラーメッセージを表示して頂きたいです。）
$error_code     = $response['error_code'];
//エラーメッセージ
$error_message  = $response['error_message'];
//レストラン
$restaurants    = $response['restaurants'];
//ジャンル
$genres         = $response['genres'];
//タグ
$tags           = $response['tags'];
?>

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
    if (!empty($restaurants)) {
        foreach ($restaurants as $rest) {
    ?>
            <a href="<?php echo $this->Html->url(array("controller" => "Restaurants", "action" => "detail", '?' => array('restaurant_id' => $rest['id']))); ?>"><div class="img ratioFixed" style="background-image:url('<? echo $rest["photo_url"]; ?>')">
                <div class="titleBox titleBox-top">
                    <!-- <div class="map">map</div> -->
                    <ul class="tags">
                    <?  
                        if (!empty($rest["tag_id"])) {
                            foreach ($rest["tag_id"] as $tag_id) {
                                echo ' <li>'.$tags[$tag_id]['name'].'</li>';
                            }
                        }
                    ?>
                    </ul>
                    <p class="category"><? echo $genres[$rest["genres_id"]]; ?></p>
                    <h4><? echo $rest["name"]; ?></h4>
                    <p class="menu"><? echo $rest["coupons"]["price"]; ?>円メニュー:<? echo $rest["coupons"]["set_menu_name"]; ?><label <? if((int)$rest["coupons"]["count"]<=1) echo 'class="is-hidden"' ?>>..他<?echo $rest["coupons"]["count"]-1?>つ</label></p>
                </div>
            </div></a>
    <?
        }
    }
    ?>
</div>