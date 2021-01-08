<?php
//例外処理
try {
    $db = new PDO('mysql:dbname=heroku_d3dc7474987db84;host=us-cdbr-east-02.cleardb.com;charset=utf8','b62e0538d36255','36fe19fb');
} catch(PDOException $e){
    print('DB接続エラー:'.$e->getMessage());
}
 ?>