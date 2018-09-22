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
    <title>サンロクマル農園</title>
</head>
<body>
<?php

try {
    $pro_code =$_GET['procode'];

    $dsn = 'mysql:dbname=shop;unix_socket=/opt/local/var/run/mysql56/mysqld.sock;host=localhost;charset=utf8';
    $user = 'shop';
    $password = 'colopl1qaz';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT name,price,gazou FROM mst_product WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $pro_code;
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $pro_name = $rec['name'];
    $pro_price = $rec['price'];
    $pro_gazou_name_old = $rec['gazou'];

    $dbh = null;

    if($pro_gazou_name_old == '') {
        $disp_gazou = '';
    } else {
        $disp_gazou = '<img src="./gazou/'.$pro_gazou_name_old.'">';
    }

} catch(Exception $e) {
    echo 'ただいま障害により大変ご迷惑お掛けしております。';
    exit();
}
?>

商品修正<br />
<br />
商品コード<br />
<?php echo $pro_code; ?>
<br />
<br />
<form method="post" action="pro_edit_check.php" enctype="multipart/form-data">
    <input type="hidden" name="code" value="<?php echo $pro_code; ?>">
    <input type="hidden" name="gazou_name_old" value="<?php echo $pro_gazou_name_old; ?>">
    商品名<br />
    <input type="text" name="name" style="width:200px" value="<?php echo $pro_name ?>"><br />
    価格<br />
    <input type="price" name="price" style="width:50px" value="<?php echo $pro_price;?>">円<br />
    <br />
    <?php echo $disp_gazou; ?>
    <br />
    画像を選んでください。<br />
    <input type="file" name="gazou" style="width:400px"><br />
    <br />
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
</form>
</body>
</html>
