<?php

$tsuki = $_POST['tsuki'];

$yasai[] = '';
$yasai[] = 'ブロッコリー';
$yasai[] = 'カリフラワー';
$yasai[] = 'レタス';
$yasai[] = 'みつば';
$yasai[] = 'アスパラガス';
$yasai[] = 'セロリ';
$yasai[] = 'ナス';
$yasai[] = 'ピーマン';
$yasai[] = 'オクラ';
$yasai[] = 'さつまいも';
$yasai[] = '大根';
$yasai[] = 'ほうれん草';

echo $tsuki;
echo '月は';
echo $yasai[$tsuki];
echo 'が旬です。';
?>
