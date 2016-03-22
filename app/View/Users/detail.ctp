<!-- Users/detail.ctp 設定ページ -->
<?php
$this->assign('title', '設定');
if(!empty($response['user_data'])){
    $u    = $response['user_data'];
}
?>
<h2>アカウント設定</h2>
<div class="titleBox titleBox-userSetting">
<p>このユーザーでログインしています</p>
<p>
    <label><i class="fa fa-building-o"></i><?php echo $u['company']['name']?></label><br/>
    <label><i class="fa fa-user"></i><?php echo $u['user']['name']?> さん</label>
</p>
</div>
<ul class="information small">
    <a href="<?php echo $this->Html->url(array("controller" => "Users", "action" => "password")); ?>" class="a"><li>パスワード変更</li></a>
    <a class="a" onclick="if(confirm('ログアウトしてよろしいですか？')) location.href='<?php echo $this->Html->url(array("controller" => "Users", "action" => "logout")); ?>';"><li>ログアウト</li></a>
</ul>

<script>
deleteFlashMessage();
</script>