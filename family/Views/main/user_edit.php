<?php
session_start();
require_once(ROOT_PATH. 'Controllers/FamilyController.php');
$user_edit = new FamilyController();
$login_user = $_SESSION['login_user'];

$log_result = $user_edit->checkLogin();
if(!$log_result) {
  $_SESSION['login_err'] = 'ユーザーアカウントを登録してください!';
  header('Location: ../login/login.php');
  return;
}


if(empty($_SESSION['edit_ticket'])) {
  header('Location:main.php');
}

if(!empty($_POST)) {
  $validation = $user_edit->User_Edit_Vd();

  if(isset($validation) && $validation === true) {
    $result = $user_edit->User_UPdate();

    if(isset($result) && $result = true) {
      $user_edit->Account_UPdate();
      header('Location: main.php');
    }

  }else {
    $err = $validation;
  }
}

/*if(!empty($_FILES)) {

$filename = $_FILES['image']['name'];

$uploaded_path = 'images'.$filename;

$src = move_uploaded_file($_FILES['upload_image']['tmp_name'],$uploaded_path);
}*/
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/click.js"></script>
</head>
<body>
  <?php include_once('main_header.php');?>
  <main>
    <div class="user_edit_box">
      <h2>ユーザー情報編集</h2>

      <?php if(isset($err)) :?>
        <?php foreach($err as $error) :?>
          <?="<p>".$error."</p>" ?>
        <?php endforeach;?>
      <?php endif;?>

      <div class="user_edit_form">
        <form action="user_edit.php" id="edit_confirm" method="post" enctype="multipart/form-data">
          <!--<div class="user_image_preview" id="myImage"></div>-->
          <img id="myImage">
          <dl>
            <input type="file" id="image" name="image">

            <dt><label>ユーザーネーム</label></dt>
            <dd><input type="text" name="name" value="<?=$login_user['name']?>"></dd>

            <dt><label>子供の人数</label></dt>
            <dd>男の子<input type="number" name="male" value="<?=$login_user['male']?>"></dd>
            <dd>女の子<input type="number" name="female" value="<?=$login_user['female']?>"></dd>
            <input type="hidden" name="id" value="<?=$login_user['id']?>">
          </dl>
          <dl>
            <dd class="edit_or_back">
              <input type="submit" id="edit" name="edit" value="編集する">
              <a href="main.php">編集を中止する</a>
            </dd>
          </dl>
        </main>
        <?php include_once('main_footer.php'); ?>
      </body>
      </html>
