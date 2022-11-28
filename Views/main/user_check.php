<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
$user_check = new FamilyController();
$login_user = $_SESSION['login_user'];

$result = $user_check->checkLogin();
if(!$result) {
  $_SESSION['login_err'] = 'ユーザーアカウントを登録してください!';
  header('Location: ../login/login.php');
  return;
}


if(!empty($_POST)) {
  $validation = $user_check->User_Check();

  if(isset($validation) && $validation === true) {
    $_SESSION['edit_ticket'] = true;
    header('Location: user_edit.php?id='.$login_user['id']);
  }
}

$err = $validation;?>

<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <?php include_once('main_header.php');?>

  <main>
    <div class="user_check_form">
      <h2>アカウント編集</h2>

      <div class="form_case">
        <?php if(isset($err)) : ?>
          <?php foreach($err as $error) :?>
            <?= "<p>".$error."</p>" ?>
          <?php endforeach;?>
        <?php endif;?>

        <?php //エラー確認
        //var_dump($_SESSION['login_user']);
        //print_r($_SESSION['login_user']);
        ?>

        <form action="user_check.php" method="POST" >
          <dl>
            <dd>
              <label>メールアドレス:</label><input type="email" name="email" placeholder="メールアドレス">
            </dd>

            <dd>
              <label>パスワード:</label><input type="password" name="password" placeholder="パスワード">
            </dd>
          </dl>
        </div>
        <dl>
          <dd class="edit_or_back">
            <input type="submit" id="user_edit" name="user_edit" value="編集する">
            <a href="main.php">編集を中止する</a>
          </dd>
        </dl>
      </div>
    </main>
    <?php include_once('main_footer.php'); ?>
  </body>
  </html>
