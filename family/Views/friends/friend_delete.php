<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
$friend = new FamilyController();

}

$friend->friend_Delete();


if($_SESSION['f_token']){
  $params = $friend->friend_Name();
  $name = $params['name'];
}
unset($_SESSION['f_token']);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <?php include_once(ROOT_PATH.'Views/main/main_header.php');?>

  <div class="complete">
    友達：<?=$name?>を解除しました。</br>
    <a href="friends_post_index.php">友達一覧ページに戻る</a>
    <?php include_once(ROOT_PATH.'Views/main/main_footer.php'); ?>
  </body>
  </html>
