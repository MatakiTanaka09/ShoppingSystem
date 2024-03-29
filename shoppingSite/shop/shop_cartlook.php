<?
session_start();
session_regenerate_id(true);
if($_SESSION['member_login'] == false) {
        echo 'ようこそゲスト様<br />';
            echo '<a href="member_login.html">会員ログイン</a>';
            echo '<br />';
} else {
    echo 'ようこそ';
    echo $_SESSION['staff_name'];
    echo ' 様<br />';
    echo '<a href="member_logout.php">ログアウト</a><br />';
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

    if(isset($_SESSION['cart']) == true) {
        $cart = $_SESSION['cart'];
        $kazu = $_SESSION['kazu'];
        $max = count($cart);
    } else {
        $max = 0;
    }

    if($max == 0) {
        echo 'カートに商品が入っていません。<br />';
        echo '<br />';
        echo '<a href="shop_list.php">商品一覧に戻る</a>';
        exit();
    }

    $dsn = 'mysql:dbname=shop;unix_socket=/opt/local/var/run/mysql56/mysqld.sock;host=localhost;charset=utf8';
    $user = 'shop';
    $password = 'colopl1qaz';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    foreach($cart as $key => $val) {
        $sql = 'SELECT code,name,price,gazou FROM mst_product WHERE code=?';
        $stmt = $dbh->prepare($sql);
        $data[0] = $val;
        $stmt->execute($data);

        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        $pro_name[] = $rec['name'];
        $pro_price[] = $rec['price'];
        if($rec['gazou'] == '') {
            $pro_gazou = '';
        } else {
            $pro_gazou[] = '<img src="../product/gazou/'.$rec['gazou'].'">';
        }
    }
    $dbh = null;

} catch(Exception $e) {
    echo 'ただいま障害により大変ご迷惑お掛けしております。';
    exit();
}
?>
    <br />
    <form method="post" action="kazu_change.php">
        カートの中身<br />
        <br />
        <table border="1">
            <tr>
                <td> 商品 </td>
                <td> 商品画像 </td>
                <td> 価格  </td>
                <td> 数量  </td>
                <td> 小計  </td>
                <td> 削除  </td>
            </tr>
            <?php for($i = 0; $i < $max; $i += 1) {?>
            <tr>
                <td><?php echo $pro_name[$i];?></td>
                <td><?php echo $pro_gazou[$i]?></td>
                <td><?php echo $pro_price[$i].'円';?></td>
                <td><input type="text" name="kazu<?php echo $i; ?>" value="<?php echo $kazu[$i] ; ?>"></td>
                <td><?php echo $pro_price[$i] * $kazu[$i]?>円</td>
                <td><input type="checkbox" name="sakujo<?php echo $i; ?>"></td>
            </tr>
            <?php } ?>
        </table>
        <input type="hidden" name="max" value="<?php echo $max; ?>">
        <input type="submit" value="数量変更"><br />
        <input type="button" onclick="history.back()" value="戻る">
    </form>
    <br />
    <a href="shop_form.html">ご購入手続きへ進む</a><br />
    <?php if(isset($_SESSION['member_login']) == true) {
            echo '<a href="shop_kantan_check.php">会員かんたん注文へ進む</a><br />';
    } ?>
</body>
</html>
