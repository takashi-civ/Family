<?php
session_start();

unset($_SESSION['send_account']);

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/login-style.css">
</head>
<body>
  <main>
    <?php include_once('login_header.php');?>

    <div class="complete">
      パスワードをリセットしました。</br>
      <a href="login.php">ログインページに戻る</a>
    </main>
    <?php include_once('login_footer.php'); ?>
  </body>
  </html>
