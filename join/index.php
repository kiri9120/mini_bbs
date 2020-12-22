<?php
session_start();
require('../dbconnect.php');


if(!empty($_POST)) {

    // エラーチェック
	if($_POST['name'] === '') {
		$error['name'] = 'blank';
	}
	if($_POST['email'] === '') {
		$error['email'] = 'blank';
	}
	if(strlen($_POST['password']) < 4) {
		$error['password'] = 'length';
	}
	if($_POST['password'] === '') {
		$error['password'] = 'blank';
	}
	$fileName = $_FILES['image']['name'];
	if(!empty($fileName)) {
		$ext = substr($fileName, -3);
		if ($ext != 'jpg' && $ext != 'png'  && $ext !='gif') {
			$error['image'] = 'type';
		}
	}

	//アカウントの重複をチェック
	if(empty($error)) {
		$member = $db->prepare('SELECT COUNT(*) as cnt FROM members WHERE email=?');
		$member->execute(array($_POST['email']));
		$record = $member->fetch();
		if ($record['cnt'] > 0) {
			$error['email'] = 'duplicate';
		}
    }

    // アップされた画像ファイルをDBに保存
	if(empty($error)) {
        $image = '';
        if(!empty($fileName)) {
            $image = date('YmdHis') . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], '../member_picture/' . $image);
        }
		$_SESSION['join'] = $_POST;
		$_SESSION['join']['image'] = $image;
		header('Location: check.php');
		exit();
	}
}

if($_REQUEST['action'] === 'rewrite' && isset($_SESSION['join'])) {
	$_POST = $_SESSION['join'];
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>会員登録</title>
    <link rel="stylesheet" href="../bulma/css/bulma.min.css">
    <link rel="stylesheet" href="../style.css" />
</head>

<body>
    <div class="wrap">
        <header class="header">
            <h1 class="h1">会員登録</h1>
        </header>
        <div class="container is-max-desktop">
            <p class="mb-5">次のフォームに必要事項をご入力ください。</p>
            <form action="" method="post" enctype="multipart/form-data">
                <dl>
                    <dt>ニックネーム<span class="tag is-danger ml-3">必須</span></dt>
                    <dd>
                        <input type="text" class="input" name="name" size="35" maxlength="255"
                            value="<?php print(htmlspecialchars($_POST['name'], ENT_QUOTES)); ?>" />
                    </dd>
                    <?php if($error['name'] === 'blank'): ?>
                    <p class="error">ニックネームを入力してください</p>
                    <?php endif; ?>
                    <dt>メールアドレス<span class="tag is-danger ml-3">必須</span></dt>
                    <dd>
                        <input type="text" class="input" name="email" size="35" maxlength="255"
                            value="<?php print(htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>" />
                    </dd>
                    <?php if($error['email'] === 'blank'): ?>
                    <p class="error">メールアドレスを入力してください</p>
                    <?php endif; ?>
                    <?php if($error['email'] === 'duplicate'): ?>
                    <p class="error">指定されたメールアドレスは既に登録されています</p>
                    <?php endif; ?>
                    <dt>パスワード<span class="tag is-danger ml-3">必須</span></dt>
                    <dd>
                        <input type="password" class="input" name="password" size="10" maxlength="20"
                            value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>" />
                    </dd>
                    <?php if($error['password'] === 'length'): ?>
                    <p class="error">パスワードは4文字以上で入力してください</p>
                    <?php endif; ?>
                    <?php if($error['password'] === 'blank'): ?>
                    <p class="error">パスワードを入力してください</p>
                    <?php endif; ?>
                    <dt>プロフィール画像</dt>
                    <dd>
                        <input type="file" name="image" size="35" value="test" />
                    </dd>
                    <?php if($error['image'] === 'type'): ?>
                    <p class="error">画像ファイルはjpg, png, gif形式を指定してください</p>
                    <?php endif; ?>
                    <?php if(!empty($error)): ?>
                    <p class="error">恐れ入りますが、画像を改めて指定してください</p>
                    <?php endif; ?>
                </dl>
                <div class="mt-6 has-text-centered">
                    <input type="submit" class="button is-link" value="入力内容を確認する" />
                </div>
            </form>
        </div>
    </div>
</body>

</html>