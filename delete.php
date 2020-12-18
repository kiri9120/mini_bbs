<?php
session_start();
require('dbconnect.php');

if(isset($_SESSION['id'])) {
    $id = $_REQUEST['id'];
    $messages = $db->prepare('SELECT * FROM posts WHERE id=?');
    $messages->execute(array($id));
    $message = $messages->fetch();

    // DBに登録されているメッセージのメンバーidとログインユーザーのidが一致すれば削除
    if($message['member_id'] == $_SESSION['id']) {
        $del = $db->prepare('DELETE FROM posts WHERE id=?');
        $del->execute(array($id));
    }
}

header('Location: index.php');
exit();
?>