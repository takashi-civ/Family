<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
require_once (ROOT_PATH. 'function.php');
$edit = new FamilyController();

$params = $edit->Post_One_id();
if(isset($params)) {
  $userOne = $params['userOne'];
  $_SESSION['e_token'] = true;
}

if(isset($_SESSION['edit_err'])) {
  $err = $_SESSION['edit_err'];
}
unset($_SESSION['edit_err']);?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/click.js"></script>
</head>
<body>
  <?php include_once(ROOT_PATH.'Views/main/main_header.php');?>
  <main>
    <div class="post_edit_box">
      <h2>投稿内容編集</h2>



      <?php if(isset($err)) :?>
        <?php foreach($err as $error):?>
          <?='<p>'.$error.'</p>'?>
        <?php endforeach;?>
      <?php endif;?>
      <form action="edit_complete.php" id="edit_confirm" method="post" enctype="multipart/form-data">
        <div class="post_edit_form">
          <img id="myImage">
          <dl>
            <input type="file" id="image" name="image">


            <dt><label>タイトル</label></dt>
            <dd><input type="text" id="title" name="title" value="<?=h($userOne['title'])?>"></dd>

            <dt><label>記事内容</label></dt>
            <dd><textarea name="text" id="textarea" rows="15" cols="60"><?=h($userOne['text'])?></textarea></dd>
          </dl>
        </div>
        <dl>
          <dd class="edit_or_back">
            <input type="submit" id="edit" name="edit" value="編集する">
            <a href="../main/view.php?id=<?=$userOne['id']?>">編集を中止する</a>
          </dd>
        </dl>
      </form>
    </main>
    <?php include_once(ROOT_PATH.'Views/main/main_footer.php'); ?>
  </body>
  </html>
