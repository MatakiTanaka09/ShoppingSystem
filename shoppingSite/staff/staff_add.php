<?php
session_start();
session_regenerate_id(true);
if($_SESSION['login'] == false) {
    echo 'ログインされていません。<br />';
    echo '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
} else {
    echo $_SESSION['staff_name'];
    echo 'さんログイン中<br />';
    echo '<br />';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>サンロクマル農園</title>
</head>
<body>
    スタッフ追加<br />
    <br />
    <form action="staff_add_check.php" method="post">
        スタッフ名を入力してください。<br />
        <input type="text" name="name" style="width:200px"><br />
        パスワードを入力してください。<br />
        <input type="password" name="pass" style="width:100px"><br />
        パスワードをもう一度入力してください。<br />
        <input type="password" name="pass2" style="width:100px"><br />
        <br />

        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="OK"><br />
    </form>
</body>
</html>
