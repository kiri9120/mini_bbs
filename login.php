<?php
session_start();
require('dbconnect.php');

if($_COOKIE['email'] !== '') {
  $email = $_COOKIE['email'];
}

if(!empty($_POST)) {
  $email = $_POST['email'];

  if($_POST['email'] !== '' && $_POST['password'] !== '') {
    $login = $db->prepare('SELECT * FROM members WHERE email=? AND password=?');
    $login->execute(array(
      $_POST['email'],
      sha1($_POST['password'])
    ));
    $member = $login->fetch();

    if($member) {
      $_SESSION['id'] = $member['id'];
      $_SESSION['time'] = time();

      if($_POST['save'] === 'on') {
        setcookie('email', $_POST['email'], time() + 60 * 60 * 24 * 14);
      }
      header('Location: index.php');
      exit();
    } else {
      $error['login'] = 'failed';
    }
  } else {
    $error['login'] = 'blank';
  }
}
 ?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>ログインする</title>
    <link rel="stylesheet" href="node_modules/bulma/css/bulma.min.css">
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
    <div class="wrap">
        <header class="header">
            <h1 class="h1">ログイン</h1>
        </header>
        <div class="container is-max-desktop">
            <div id="lead">
                <p>メールアドレスとパスワードを入力してログインしてください。</p>
                <p class="mt-4"><a href="join" class="underline">会員登録がまだの方はこちら</a></p>
            </div>
            <form action="" method="post">
                <dl>
                    <dt>メールアドレス</dt>
                    <dd>
                        <input type="text" class="input" name="email" size="35" maxlength="255"
                            value="<?php print htmlspecialchars($email, ENT_QUOTES); ?>" />
                        <?php if($error['login'] === 'blank' ): ?>
                        <p class="error">メールアドレスとパスワードをご記入ください</p>
                        <?php endif; ?>
                        <?php if($error['login'] === 'failed' ): ?>
                        <p class="error">ログインに失敗しました。正しくご記入ください</p>
                        <?php endif; ?>
                    </dd>
                    <dt>パスワード</dt>
                    <dd>
                        <input type="password" class="input" name="password" size="35" maxlength="255"
                            value="<?php print htmlspecialchars($_POST['password'], ENT_QUOTES); ?>" />
                    </dd>
                    <p class="mt-4">
                        <input id="save" class="is-clickable" type="checkbox" name="save" value="on">
                        <label for="save" class="is-clickable">次回からは自動的にログインする</label>
                    </p>
                </dl>
                <div class="mt-5 has-text-centered">
                    <input type="submit" class="button is-link" value="ログインする" />
                </div>
            </form>
        </div>
    </div>
</body>

</html>