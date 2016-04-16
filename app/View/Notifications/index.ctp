<?php
    $this->assign('title', '運営からのお知らせ');
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
$v = array_search_value($notices, 'important_flg');
if($v) {
?>
<ul class="information important">
<?php
    echo '<a href="';
    echo $this->Html->url(array("controller" => "Notifications", "action" => "detail", '?' => array('notification_id' => $v['id'])));
    echo '" ';
    if($v["important_flg"]) {echo 'class="is-important">'; }
    else { echo '>'; }
    echo '<li><label class="date">'.date("m/d",$v["start_date"]).'</label> ';
    echo $v["title"].'</li></a>';
?>
</ul>
<?php } ?>

<ul class="information small">
    <?php
    if (isset($notices) && count($notices) > 0) {
        foreach ($notices as $notice) {
            echo '<a href="';
            echo $this->Html->url(array("controller" => "Notifications", "action" => "detail", '?' => array('notification_id' => $notice['id'])));
            echo '" ';
            if($notice["important_flg"]) {echo 'class="is-important">'; }
            else { echo '>'; }
            echo '<li><label class="date">'.date("m/d",$notice["start_date"]).'</label> ';
            echo $notice["title"].'</li></a>';
        }
    }
    ?>
</ul>

<?php
function array_search_value($datas, $key) {
    if(isset($datas) && isset($key)) {
        foreach($datas as $data) {
            foreach($data as $k => $v) {
                if ($k == $key)
                    if ($data[$k])
                        return $data;
            }
        }
    }
    return false;
}
?>