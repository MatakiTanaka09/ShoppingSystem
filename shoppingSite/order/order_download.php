<?
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
    <title></title>
</head>
<body>
<?php
require_once('../common/common.php');

?>
    ダウンロードしたい注文日を選んでください。<br />
    <form action="order_download_done.php" method="post">
        <?php pulldown_year(); ?>
        年
        <?php pulldown_month(); ?>
        月
        <?php pulldown_day(); ?>
        </select>
        日
        <br />
        <input type="submit" value="ダウンロードへ">
    </form>
</body>
</html>
