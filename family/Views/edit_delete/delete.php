<?php
session_start();
require_once (ROOT_PATH . 'Controllers/FamilyController.php');
$delete = new FamilyController();

//セッションがあれば削除アクション実行
if(isset($_SESSION['view_id'])) {
  if(isset($_SESSION['token']) && $_SESSION['token'] === true) {
    $delete->Post_Delete();
  }
}
unset($_SESSION['view_id']);
unset($_SESSION['token']);
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
    削除完了しました。</br>
    <a href="../main/main.php">メインページに戻る</a>
    <?php include_once(ROOT_PATH.'Views/main/main_footer.php'); ?>
  </body>
  </html>
