<?php
session_start();
require('dbconnect.php');

// ログイン後1時間以内は情報を記憶
if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();

  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  $members->execute(array($_SESSION['id']));
  $member = $members->fetch();
} else {
  header('Location: login.php');
  exit();
}

if(!empty($_POST)) {
  if($_POST['message'] !== '') {
    $message = $db->prepare('INSERT INTO posts SET member_id=?, message=?, reply_message_id=?, created=NOW()');
    $message->execute(array(
      $member['id'],
      $_POST['message'],
      $_POST['reply_post_id']
    ));

    header('Location: index.php');
    exit();
  }
}

// ページネーション------------------------

// 空白または1より小さい時は1ページ目を表示
$page = $_REQUEST['page'];
if($page == '') {
  $page = 1;
}
$page = max($page, 1);

// DBから投稿件数を取得し最大ページ数を計算、それより大きい値が入力された時は最後のページを表示
$counts = $db->query('SELECT COUNT(*) AS cnt FROM posts');
$cnt = $counts->fetch();
$maxPage = ceil($cnt['cnt'] / 5);
$page = min($page, $maxPage);

$start = ($page - 1) * 5;

$posts = $db->prepare('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id ORDER BY p.created DESC LIMIT ?, 5');
$posts->bindParam(1, $start, PDO::PARAM_INT); // LIMITのパラメーターを数値で代入するためbindParam使用
$posts->execute();

// 返信処理-------------------------------
if(isset($_REQUEST['res'])) {
  $response = $db->prepare('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id AND p.id=?');
  $response->execute(array($_REQUEST['res']));

  $table = $response->fetch();
  $message = '@' . $table['name'] . ' ' . $table['message'];
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ひとこと掲示板</title>

    <link rel="stylesheet" href="bulma/css/bulma.min.css">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="wrap">
        <header class="header">
            <h1 class="h1">ひとこと掲示板</h1>
        </header>
        <div class="container is-max-desktop">
            <div class="">
                <div class="has-text-right mb-4"><a href="logout.php" class="button is-dark">ログアウト</a></div>
                <form action="" method="post">
                    <dl>
                        <dt><?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?> さん、
                            <?php
                            // 時間帯によってメッセージを出しわけ
                            $nowtime = date("H");
                            if($nowtime >= 5 && $nowtime <= 11): ?>
                            おはようございます。今日も一日頑張りましょう。
                            <?php elseif($nowtime >= 12 && $nowtime <= 17): ?>
                            こんにちは。午後も頑張りましょう。
                            <?php else: ?>
                            こんばんは。今日も一日お疲れさまでした。
                            <?php endif; ?>
                        </dt>
                        <dd>
                            <textarea name="message" cols="50" rows="5"
                                class="textarea"><?php print(htmlspecialchars($message, ENT_QUOTES)); ?></textarea>
                            <input type="hidden" name="reply_post_id"
                                value="<?php print(htmlspecialchars($_REQUEST['res'], ENT_QUOTES)); ?>" />
                        </dd>
                    </dl>
                    <div>
                        <p class="has-text-right">
                            <input type="submit" class="button is-link" value="投稿する" />
                        </p>
                    </div>
                </form>
                <div class="mt-5">
                    <h2>みんなの投稿</h2>
                    <?php foreach($posts as $post): ?>
                    <div class="msg">
                        <?php if(!empty($post['picture'])): ?>
                        <img src="member_picture/<?php print(htmlspecialchars($post['picture'], ENT_QUOTES)); ?>"
                            class="image is-48x48" alt="<?php print(htmlspecialchars($post['name'], ENT_QUOTES)); ?>" />
                        <?php else: ?>
                        <img src="member_picture/noicon.png" class="image is-48x48" alt="No Image" />
                        <?php endif; ?>
                        <p><?php print(htmlspecialchars($post['message'], ENT_QUOTES)); ?>
                            <span class="name">（<?php print(htmlspecialchars($post['name'], ENT_QUOTES)); ?>）</span>[<a
                                href="index.php?res=<?php print(htmlspecialchars($post['id'], ENT_QUOTES)); ?>">Re</a>]
                        </p>
                        <p class="day">
                            <a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
                                <?php print(htmlspecialchars($post['created'], ENT_QUOTES)); ?>
                            </a>

                            <!-- 別の投稿の返信の場合のみ返信元のメッセージ表示 -->
                            <?php if($post['reply_message_id'] > 0): ?>
                            <a
                                href="view.php?id=<?php print(htmlspecialchars($post['reply_message_id'], ENT_QUOTES)); ?>">
                                返信元のメッセージ</a>
                            <?php endif; ?>

                            <!-- 自分の投稿にのみ削除ボタン表示 -->
                            <?php if($_SESSION['id'] == $post['member_id']): ?>
                            [<a href="delete.php?id=<?php print(htmlspecialchars($post['id'])); ?>"
                                class="has-text-danger">削除</a>]
                            <?php endif; ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <nav class="pagination is-justify-content-center mx-0 mt-4">

                    <?php if($page > 1): ?>
                    <a href="index.php?page=<?php print($page - 1); ?>" class="pagination-previous">前のページへ</a>
                    <?php else: ?>
                    <a class="pagination-previous" disabled>前のページへ</a>
                    <?php endif; ?>

                    <?php if($page < $maxPage): ?>
                    <a href="index.php?page=<?php print($page + 1); ?>" class="pagination-next">次のページへ</a>
                    <?php else: ?>
                    <a class="pagination-next" disabled>次のページへ</a>
                    <?php endif; ?>

                </nav>
            </div>
        </div>
    </div>
</body>

</html>