<?php
try {
    $db = new PDO('mysql:dbname=mini_bbs; host=localhost; charset=utf8', 'root', 'root');
} catch(PDOExection $e) {
    print('DB接続エラー：' . $e->getMessage());
}
 ?>