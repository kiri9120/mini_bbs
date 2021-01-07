<?php
try {
    // $db = new PDO('mysql:dbname=mini_bbs;port=8889;host=localhost;charset=utf8', 'root', 'root');
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

    $db_name = substr($url["path"], 1);
    $db_host = $url["host"];
    $user = $url["user"];
    $password = $url["pass"];

    $dsn = "mysql:dbname=".$db_name.";host=".$db_host;

    $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
} catch(PDOException $e) {
    print('DB接続エラー：' . $e->getMessage());
}
 ?>