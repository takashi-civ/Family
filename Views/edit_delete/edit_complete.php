<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
$edit = new FamilyController();

if(!empty($_POST)) {
  $err = $edit->Post_Validate();

  if(isset($err) && $err !== true) {
    $_SESSION['edit_err'] = $err;
    unset($_SESSION['e_token']);
    header('Location: edit.php');
  }

  if(isset($_SESSION['view_id'])) {
    if(isset($_SESSION['e_token']) && $_SESSION['e_token'] === true) {
      $edit->Post_Edit();
      unset($_SESSION['view_id']);
      unset($_SESSION['e_token']);
    } else {
      echo '不正なアクセスです';
      exit;
    }
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <?php include_once(ROOT_PATH .'Views/main/main_header.php');?>

  <div class="complete">
    編集完了しました。</br>
    <a href="../main/main.php">メインページに戻る</a>
    <?php include_once(ROOT_PATH.'Views/main/main_footer.php'); ?>
  </body>
  </html>
