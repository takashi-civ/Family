<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
$admin = new FamilyController();

$admin->user_delete();?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/admin-style.css">
</head>
<body>
  <?php include_once(ROOT_PATH.'Views/admin/admin_header.php');?>

  <div class="complete">
    削除完了しました。</br>
    <a href="../admin/admin_main.php">メインページに戻る</a>
  </div>
  <?php include_once(ROOT_PATH.'Views/admin/admin_footer.php'); ?>
</body>
</html>
