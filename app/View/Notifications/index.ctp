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
$v = array_search_value($notices, 'important_flg');
if($v) {
?>
<ul class="information important">
<?
echo '<a href="/notice/'.$v["id"].'" ';
            if($v["important_flg"]) {echo 'class="is-important">'; }
            else { echo '>'; }
            echo '<li><label class="date">'.date("m/d",$v["start_date"]).'</label> ';
            echo $v["title"].'</li></a>';
?>
</ul>
<? } ?>

<ul class="information small">
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

<?
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