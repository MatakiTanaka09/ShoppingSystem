<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>星</title>
</head>
<body>
</body>
</html>
<?php

$mbango = $_POST['mbango'];

$hoshi['M1'] = 'カニ星雲';
$hoshi['M31'] = 'アンドロメダ星雲';
$hoshi['M42'] = 'オリオン星雲';
$hoshi['M45'] = 'すばる';
$hoshi['M57'] = 'ドーナツ星雲';

echo 'あなたが選んだ星は、';
echo $hoshi[$mbango];
echo 'です。';

foreach($hoshi as $key => $val) {
    echo $key;
    echo 'は';
    echo $val;
    echo 'です。';
}
?>
