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
    ショップ管理トップメニュー<br />
    <br />
    <a href="../staff/staff_list.php">スタッフ管理</a><br />
    <br />
    <a href="../product/pro_list.php">商品管理</a><br />
    <br />
    <a href="../order/order_download.php">注文ダウンロード</a><br />
    <br />
    <a href="staff_logout.php">ログアウト</a><br />
</body>
</html>
