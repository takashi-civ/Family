<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
$user_signup = new FamilyController;

if(isset($_SESSION['form'])) {
  $result = $user_signup->userCreate();

  if($result === false) {
    header("Location:signup.php");
  }
}
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
    <div class="complete">
      <p>アカウントを新規登録しました。</p>
      <a href="login.php">ログインページに戻る</a>
    </div>
  </main>
  <?php include_once('login_footer.php'); ?>
