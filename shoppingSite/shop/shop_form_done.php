<?php
session_start();
session_regenerate_id(true);
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
    require_once('../common/common.php');

    $post = sanitize($_POST);

    $onamae = $post['onamae'];
    $email = $post['email'];
    $postal1 = $post['postal1'];
    $postal2 = $post['postal2'];
    $address = $post['address'];
    $tel = $post['tel'];
    $chumon = $post['chumon'];
    $pass = $post['pass'];
    $danjo = $post['danjo'];
    $birth = $post['birth'];

    echo $onamae.様.'<br />';
    echo 'ご注文ありがとうございます。<br />';
    echo $email.'にメールを送りましたのでご確認ください。<br />';
    echo '商品は以下の住所に発送させていただきます。<br />';
    echo $postal1.'-'.$postal2.'<br />';
    echo $address.'<br /';
    echo $tel.'<br />';

    $honbun = '';
    $honbun .= $onamae."様 \n\nこの度はご注文ありがとうございます。\n";
    $honbun .= "\n";
    $honbun .= "ご注文商品\n";
    $honbun .= "--------------------\n";

    $cart = $_SESSION['cart'];
    $kazu = $_SESSION['kazu'];
    $max = count($cart);

    $dsn = 'mysql:dbname=shop;unix_socket=/opt/local/var/run/mysql56/mysqld.sock;host=localhost;charset=utf8';
    $user = 'shop';
    $password = 'colopl1qaz';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    for($i = 0; $i < $max; $i += 1) {
        $sql = 'SELECT name,price FROM mst_product WHERE code=?';
        $stmt = $dbh->prepare($sql);
        $data[0] = $cart[$i];
        $stmt->execute($data);

        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        $name = $rec['name'];
        $price = $rec['price'];
        $kakaku[] = $price;
        $suryo = $kazu[$i];
        $shokei = $price * $suryo;
        $honbun .= $name.' ';
        $honbun .= $price.'円 x';
        $honbun .= $suryo.'個 = ';
        $honbun .= $shokei."円 \n";
    }

    $sql = 'LOCK TABLES dat_sales WRITE,dat_sales_product WRITE,dat_member WRITE';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $lastmembercode = 0;
  if($chumon == 'chumontouroku') {
       $sql = 'INSERT INTO dat_member(password,name,email,postal1,postal2,address,tel,danjo,born) VALUES (?,?,?,?,?,?,?,?,?)';
       $stmt = $dbh->prepare($sql);
       $data = array();
       $data[] = md5($pass);
       $data[] = $onamae;
       $data[] = $email;
       $data[] = $postal1;
       $data[] = $postal2;
       $data[] = $address;
       $data[] = $tel;

       if($danjo == 'dan') {
            $data[] = 1;
       } else {
            $data[] = 2;
       }

       $data[] = $birth;
       $stmt->execute($data);

       $sql = 'SELECT LAST_INSERT_ID()';
       $stmt = $dbh->prepare($sql);
       $stmt->execute();
       $rec = $stmt->fetch(PDO::FETCH_ASSOC);
       $lastmembercode = $rec['LAST_INSERT_ID()'];
    }

    $sql = 'INSERT INTO dat_sales (code_member,name,email,postal1,postal2,address,tel) VALUES (?,?,?,?,?,?,?)';
    $stmt = $dbh->prepare($sql);
    $data = array();
    $data[] = $lastmembercode;
    $data[] = $onamae;
    $data[] = $email;
    $data[] = $postal1;
    $data[] = $postal2;
    $data[] = $address;
    $data[] = $tel;
    $stmt->execute($data);

    $sql = 'SELECT LAST_INSERT_ID()';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $lastcode = $rec['LAST_INSERT_ID()'];

    for($i = 0; $i < $max; $i += 1) {
        $sql = 'INSERT INTO dat_sales_product (code_sales, code_product, price, quantity) VALUES (?,?,?,?)';
        $stmt = $dbh->prepare($sql);
        $data = array();
        $data[] = $lastcode;
        $data[] = $cart[$i];
        $data[] = $kakaku[$i];
        $data[] = $kazu[$i];
        $stmt->execute($data);
    }

    $sql = 'UNLOCK TABLES';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;

    if($chumon == 'chumontouroku') {
        echo '会員登録が完了いたしました。<br />';
        echo '次回からメールアドレスとパスワードでログインしてください。<br />';
        echo 'ご注文が簡単にできるようになります。<br />';
        echo '<br />';
    }

    $honbun .= "送料は無料です。\n";
    $honbun .= "--------------------\n";
    $honbun .= "\n";
    $honbun .= "代金は以下の口座にお振込ください。\n";
    $honbun .= "サンロクマル銀行 野菜支店 普通口座 1234567\n";
    $honbun .= "入金確認が取れ次第、梱包、発送させていただきます。\n";
    $honbun .= "\n";

    if($chumon == 'chumontouroku') {
        $honbun .= "会員登録が完了いたしました。\n";
        $honbun .= "次回からメールアドレスとパスワードでログインしてください。\n";
        $honbun .= "ご注文が簡単にできるようになります。\n";
        $honbun .= "\n";
    }
    $honbun .= "--------------------\n";
    $honbun .= "安心野菜のサンロクマル農園\n";
    $honbun .= "\n";
    $honbun .= "東京都渋谷区恵比寿\n";
    $honbun .= "電話番号 090-xxxx-xxxx\n";
    $honbun .= "メール info@xxx\n";
    $honbun .= "--------------------\n";

//    echo '<br />';
//    echo nl2br($honbun);

//    $title = 'ご注文ありがとうございます。';
//    $header = 'From:info@sanrokumarunouen.co.jp';
//    $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
//    mb_language('Japanese');
//    mb_internal_encoding('UTF-8');
//    mb_send_mail($email, $title, $honbun, $header);
//
//    $title = 'お客様からご注文がありました。。';
//    $header = "From:$email";
//    $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
//    mb_language('Japanese');
//    mb_internal_encoding('UTF-8');
//    mb_send_mail('info@sanrokumarunouen.co.jp', $title, $honbun, $header);


} catch(Exception $e) {
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>

<br />
<a href="shop_list.php">商品画面へ</a>
</body>
</html>
