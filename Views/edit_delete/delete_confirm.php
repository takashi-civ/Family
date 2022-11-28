<?php
session_start();
require_once (ROOT_PATH . 'Controllers/FamilyController.php');
require_once (ROOT_PATH . 'function.php');
$delete = new FamilyController();


$params = $delete->Post_One_id();
if(isset($params))
{
  $userOne = $params['userOne'];
  $_SESSION['token'] = true;
}

if(empty($_SSSION['token'])) {
  header('../main/view.php?id='.$userOne['id']);
}?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <?php include_once(ROOT_PATH.'Views/main/main_header.php');?>

  <main>
    <div class="delete_confirm_h3">
      <h3>こちらの投稿を削除しますか</h3>
    </div>
    <div class="delete_confirm_dd">
      <dl>
        <dt><label>タイトル</label></dt>
        <dd><?= h($userOne['title'])?></dd>
      </div>
      <div class="delete_confirm_dd">
        <dt><label>投稿内容</label></dt>
        <dd><?= nl2br(h($userOne['text']))?></dd>
      </dl>
    </div>

    <div class="delete_or_back">
      <form action="delete.php" method="post">
        <input type="submit" id="delete" name="delete" value="削除する">
      </form>
      <a href="../main/view.php?id=<?=$userOne['id']?>">削除を中止する</a>
    </div>
  </main>
  <?php include_once(ROOT_PATH.'Views/main/main_footer.php'); ?>
</body>
</html>
