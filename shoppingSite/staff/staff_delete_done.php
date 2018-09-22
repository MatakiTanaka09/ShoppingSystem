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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>サンロクマル農園</title>
</head>
<body>
<?php
try{

    $staff_code = $_POST['code'];

    $dsn = 'mysql:dbname=shop;unix_socket=/opt/local/var/run/mysql56/mysqld.sock;host=localhost;charset=utf8';
    $user = 'shop';
    $password = 'colopl1qaz';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'DELETE FROM mst_staff WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $staff_code;
    $stmt->execute($data);
    $dbh = null;

} catch(Exception $e) {
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>
削除しました。<br />
<br />
<a href="staff_list.php">戻る</a>
</body>
</html>
