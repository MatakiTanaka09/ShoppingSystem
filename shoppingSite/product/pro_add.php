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
    商品追加<br />
    <br />
    <form action="pro_add_check.php" method="post" enctype="multipart/form-data">
        商品名を入力してください。<br />
        <input type="text" name="name" style="width:200px"><br />
        価格を入力してください。<br />
        <input type="text" name="price" style="width:50px"><br />
        画像を選んでください。<br />
        <input type="file" name="gazou" style="width:400px">
        <br />

        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="OK"><br />
    </form>
</body>
</html>
