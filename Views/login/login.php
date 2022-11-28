<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
$login_user = new FamilyController();

if(!empty($_POST)) {
  $validate = $login_user->loginValidate();

  if(isset($validate) && $validate === true) {
    $result = $login_user->userLogin();

    if($result === true) {
      header('Location: ../main/main.php');
    }
  } else {
    $err = $validate;
  }
}

if(isset($_SESSION['msg'])) {
  $msg = $_SESSION['msg'];
}

if(isset($_SESSION['login_err'])) {
  $login_err = $_SESSION['login_err'];
  unset($_SESSION['login_err']);
}

unset($_SESSION['msg']);
unset($_SESSION['send_account']);
?>

<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/login-style.css">
</head>
<body>
  <?php include_once('login_header.php'); ?>
  <main>

    <div class="login_form">
      <div class="form_case">
        <?php if(isset($err)) :?>
          <?php foreach($err as $errors) :?>
            <?= "<p>".$errors."</p>"?>
          <?php endforeach;?>
        <?php endif;?>

        <?php if(isset($msg)) :?>
          <?= "<p>".$msg."</p>"?>
        <?php endif;?>

        <?php if(isset($login_err)) :?>
          <?= "<p>".$login_err."</p>"?>
        <?php endif;?>

        <? //エラーチェック?>
        <?php //var_dump($_SESSION['login_user']);?>

        <form action="login.php" method="POST" >
          <div><input type="email" name="email" placeholder="メールアドレス"></div>

          <div><input type="password" name="password" placeholder="パスワード"></div>

          <div><input type="submit" id="login_button" name="login_button" value="ログイン"></div>
        </form>
        <div class="signup_entrance"><a href ="signup.php">新規アカウント作成</a></div>
        <div class="signup_entrance"><a href ="mail_send.php">パスワードを忘れた方はこちら</a></div>
      </div>
    </div>

    <div class="admin_login">
      <a href="../admin/admin_log.php">管理者はこちら</a>
    </div>
  </main>
</body>
</html>
<?php include_once('login_footer.php'); ?>
