<?php
session_start();
require_once (ROOT_PATH. 'function.php');

if(isset($_SESSION['create_err'])) {
  $err = $_SESSION['create_err'];
}
unset($_SESSION['create_err']);

if(!$_SESSION['login_user']['id']) {
  header('Location: ../main/main.php');
}

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
  <?php include_once(ROOT_PATH. 'Views/main/main_header.php')?>

  <main>
    <div class="post_create_box">
      <h2>投稿作成</h2>

      <?php //エラー確認?>
      <?php //var_dump($_SESSION['login_user']['id']);?>
      <?php //エラー確認 ?>

      <div class="post_create_form">
        <form action="create_confirm.php" id="create_confirm" method="post" enctype="multipart/form-data">

          <?php if(isset($err)) :?>
            <?php foreach($err as $error) :?>
              <?= "<p>".$error."</p>" ?>
            <?php endforeach;?>
          <?php endif;?>

          <!--<div class="post_image_preview"></div>-->
          <img id="myImage">
          <dl>
            <input type="file" id="image" name="image" >

            <dt><label>タイトル</label></dt>
            <dd><input type="text" name="title" value=""></dd>

            <dt><label>記事内容</label></dt>
            <dd><textarea name="text" rows="6" cols="60" ></textarea></dd>
          </dl>
          <dl>
            <dd class="create_or_back">
              <input type="submit" id="create_post_Btn" name="create" value="作成する">
              <a href="../main/main.php">キャンセル</a>
            </dd>
          </dl>
        </form>
      </main>
      <?php include_once(ROOT_PATH. 'Views/main/main_footer.php'); ?>
    </body>
    </html>
