<!-- Users/password.ctp パスワード設定ページ -->
<?php
$this->assign('title', 'パスワード変更');
?>

<form class="password pdlr-10" name="changePassword" action="" method="post">
    <p>新しいパスワードを入力してください(7~14文字)</p>
    <input type="password" name="password" placeholder="新しいパスワード">
    <input type="password" name="password_confirm" placeholder="新しいパスワード（確認）">
</form>
<div class="mgt-15 pdlr-10">
    <button class="button" onclick="validationConfirm()">パスワード変更を送信する</button>
    <button class="cancel" onclick="history.back()">戻る</button>
</div>

<script>
var validationConfirm = function() {
    var pasV = $("input[name=password]")[0].value;
    var pascV = $("input[name=password_confirm]")[0].value;
    if (!pasV || !pascV) {
        showFlashMessage("パスワードが入力されていません");
    } else if (pasV != pascV) {
        showFlashMessage("パスワードの入力内容が違います");
    } else if (window.confirm('パスワード変更を送信します。よろしいですか？')) {
        document.changePassword.submit();
    }
}
</script>