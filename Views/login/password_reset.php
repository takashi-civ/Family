<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
$pass_reset = new FamilyController();

if(!empty($_POST)) {
  $err = $pass_reset->pass_Reset_Validate();

  if(isset($err) && $err === true) {
    $result = $pass_reset->pass_Reset();

    if(isset($result) && $result === true) {
      header('Location: password_reset_true.php');
    }
  }
  $_SESSION['pass_reset_err'] = $err;

}

$err = $_SESSION['pass_reset_err'];
unset($_SESSION['pass_reset_err']);
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/login-style.css">
</head>
<body>
  <?php include_once('login_header.php');?>
  <main>
    <div class="password_reset_box">
      <h2>メール送信画面</h2>
      <div class="password_reset_form">

        <?php if(isset($err)) :?>
          <?php foreach($err as $errors) :?>
            <?="<p>".$errors."</p>"?>
          <?php endforeach;?>
        <?php endif;?>
        <form action="password_reset.php" id="password_reset_true" method="post">
          <dl>
            <dt><label>パスワード</label></dt>
            <dd><input type="password" name="password" value=""></dd>

            <dt><label>パスワード確認</label></dt>
            <dd><input type="password" name="password_conf" value=""></dd>
          </dl>
          <dl>
          </div>
          <dd class="send_or_back">
            <input type="submit" id="reset" name="reset" value="パスワード変更">
            <a href="login.php">ログインページに戻る</a>
          </dd>
        </dl>
      </main>
      <?php include_once('login_footer.php'); ?>
    </body>
    </html>
