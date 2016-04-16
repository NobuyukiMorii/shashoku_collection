<?php
    $this->assign('title', '運営からのお知らせ');
    ////////// ダミーデータ //////////
    $notice = array(
        'id' => '0',
        'title' => '【重要】12月から○○が変更になります',
        'comment' => '【重要】12月から○○が変更になりますのコメントコメントコメントコメントコメントコメントコメントコメント',
        'restaurant_list_banner_flg' => '1',
        'important_flg' => '1',
        'start_date' => '1451574000',
        'close_date' => '1452351600'
    );
?>

<div class="noticeDetailBox">
    <h3 class="title"><?php echo $notice["title"] ?></h3>
    <p class="date"><?php echo $notice["start_date"] ?></p>
    <p class="comment"><?php ehbr($notice["comment"]) ?></p>
</div>