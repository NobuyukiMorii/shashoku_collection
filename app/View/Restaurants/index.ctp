<!-- Restaurants/index.ctp トップページ レストラン一覧 -->
<?php
$this->assign('title', '<img src="img/logo.png">');
//エラーコード（0以外の場合、いい感じにエラーメッセージを表示して頂きたいです。）
$error_code     = $response['error_code'];
//エラーメッセージ
$error_message  = $response['error_message'];
//レストラン
if(!empty($response['restaurants'])){
    $restaurants    = $response['restaurants'];
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

<!-- お知らせ -->
<?php if($error_code === 0): ?>

    <ul class="information small">
        <?php
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

        <?php
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

        <?php
        if (!empty($restaurants)) {
            foreach ($restaurants as $rest) {
                // 整形
                $menu_name = $rest["coupons"]["set_menu_name"];
                $menu_len = mb_strlen($menu_name);
                if ($menu_len > 17) {
                    $menu_name = mb_substr($menu_name, 0, 17)."..";
                }
        ?>
                <a href="<?php echo $this->Html->url(array("controller" => "Restaurants", "action" => "detail", '?' => array('restaurant_id' => $rest['id']))); ?>" class="a"><div class="img ratioFixed" style="background-image:url('<?php echo $rest["photo_url"]; ?>')">
                    <div class="titleBox titleBox-top">
                        <!-- <div class="map">map</div> -->
                        <ul class="tags">
                        <?php  
                            if (!empty($rest["tag_id"])) {
                                foreach ($rest["tag_id"] as $tag_id) {
                                    echo ' <li style="background-color:'.$tags[$tag_id]['color_code'].';">'.$tags[$tag_id]['name'].'</li>';
                                }
                            }
                        ?>
                        </ul>
                        <p class="category"><?php echo $genres[$rest["genres_id"]]; ?></p>
                        <h4><?php echo $rest["name"]; ?></h4>
                        <p class="menu"><?php echo $rest["coupons"]["price"]; ?>円:<?php echo $menu_name; ?><label <?php if((int)$rest["coupons"]["count"]<=1) echo 'class="is-hidden"' ?>> 他<?php echo $rest["coupons"]["count"]-1?>つ</label></p>
                    </div>
                </div></a>
        <?php
            }
        }
        ?>
    </div>

<?php endif; ?>