<?php
session_start();

$err = $_SESSION['signup_err'];

if(isset($_SESSION['limit_err'])){
  $limit_err = $_SESSION['limit_err'];
}

unset($_SESSION['signup_err']);
unset($_SESSION['limit_err']);
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

    <div class="signup_form">
      <section class="form_case">

        <form action="signup_confirm.php" method="POST" >

          <?php if(isset($limit_err)):?>
            <?= "<p>".$limit_err. "</p>"?>
          <?php endif;?>

          <?php if(isset($err)) :?>
            <?php foreach($err as $errors) :?>
              <?= "<p>".$errors."</p>"?>
            <?php endforeach;?>
          <?php endif;?>
          <?php $err = [];?>
          <div>
            <input type="text" name="name" placeholder="ユーザーネーム"></div>

            <div><input type="email" name="email" placeholder="メールアドレス"></div>

            <div><input type="text" name="password" placeholder="パスワード"></div>

            <div class="number_of_kids">
              <div><label id="number_of_kids">子供の数</label></div>
              <label>男の子</label><input class="kids" type="number" name="male" value="0">
              <label>女の子</label><input class="kids" type="number" name="female" value="0">
            </div>

            <div><input type="submit" id="signup_button" name="signup" value="アカウント作成"></div>
          </form>
          <div class="login_entrance"><a href="login.php">ログインページに戻る</a></div>
        </section>
      </div>
    </main>
  </body>
  </html>


  <?php include_once('login_footer.php'); ?>
