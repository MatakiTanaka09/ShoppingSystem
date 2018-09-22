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

    $pro_code =$_GET['procode'];

    if(isset($_SESSION['cart']) == true) {
        $cart = $_SESSION['cart'];
        $kazu = $_SESSION['kazu'];

        if(in_array($pro_code, $cart)) {
            echo 'その商品はすでにカートに入っています。<br />';
            echo '<a href="shop_list.php">商品一覧に戻る</a>';
            exit();
        }
    }

    $cart[] = $pro_code;
    $kazu[] = 1;
    $_SESSION['cart'] = $cart;
    $_SESSION['kazu'] = $kazu;

} catch(Exception $e) {
    echo 'ただいま障害により大変ご迷惑お掛けしております。';
    exit();
}
?>
カートに追加しました。<br />
<br />
<a href="shop_list.php">商品一覧に戻る</a>

</body>
</html>
