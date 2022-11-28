<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
$user_signup = new FamilyController();

//ポストにデータがあればバリテーションを行う
if(!empty($_POST)) {
  $err = $user_signup->userValidate();
  //var_dump($err);
  //exit();

  if(!empty($err) && $err === true) {
    $_SESSION['form'] = $_POST;

  }else {
    $_SESSION['signup_err'] = $err;
    header('Location: signup.php');
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

  <div class="signup_confirm_box">
    <h2>こちらの内容でアカウントを作成しますか</h2>
    <form action="signup_complete.php" method="post">

      <dl class="confirm">
        <dt>ユーザーネーム</dt>
        <dd><?=$_POST['name']?></dd>

        <dt>メールアドレス</dt>
        <dd><?=$_POST['email']?></dd>

        <dt>子供の人数</dt>
        <dd>男の子<?=$_POST['male'] ?>人、女の子<?=$_POST['female'] ?>人</dd>

        <dd class="signup_confirm_btn">
          <button type="submit" id="Btn">作成する</button>


          <a href="signup.php" id="noBtn">キャンセルする</a>
        </dd>
      </form>
    </div>

    <?php include_once('login_footer.php'); ?>
