<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
$mail_send = new FamilyController();

if(!empty($_POST)) {
  $validation = $mail_send->mail_send_Validate();

  if(isset($validation) && $validation === true) {
    $result = $mail_send->mail_send();

    if(isset($result) && $result === true) {
      header('Location: password_reset.php');
    }

  }else if(isset($validation) && $validation !== true){
    $err = $validation;
  }
}


if(isset($_SESSION['send_err'])) {
  $send_err = $_SESSION['send_err'];
}

unset($_SESSION['send_err']);
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
        <?php
        //エラーのチェック
        //var_dump($validation);
        //var_dump($result);
        //var_dump($_SESSION['send_err']);
        //var_dump($_POST);
        ?>

        <?php if(isset($send_err)) : ?>
          <?= "<p>".$send_err."</p>" ?>
        <?php endif;?>

        <?php if(isset($err)) : ?>
          <?php foreach($err as $error) :?>
            <?= "<p>".$error."</p>" ?>
          <?php endforeach;?>
        <?php endif;?>

        <form action="mail_send.php" id="password_reset" method="post">
          <dl>
            <dt><label>メールアドレス</label></dt>
            <dd><input type="email" name="email" placeholder="メールアドレス"></dd>
          </dl>
          <dl>
          </div>
          <dd class="send_or_back">
            <input type="submit" id="send" name="send" value="メール送信">
            <a href="login.php">ログインページに戻る</a>
          </dd>
        </dl>
      </main>
      <?php include_once('login_footer.php'); ?>
    </body>
    </html>
