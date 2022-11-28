<?php
session_start();
require_once(ROOT_PATH. 'Controllers/FamilyController.php');
$create = new FamilyController();


if(isset($_SESSION['create_form'])) {
  $result = $create->Create_Post() ;
  if(isset($result) && $result === false){
    echo 'データベースエラー';
    exit;
  }


} else {
  $_SESSION['create_cop_err'] = "記事を作成出来ていません。";
  header('Location: ../main/main.php');
}

unset($_SESSION['create_form']);
//unset($_SESSION['create_files']);
unset($_SESSION['image']);?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <?php include_once(ROOT_PATH.'Views/main/main_header.php');?>

  <div class="complete">
    登録完了しました。</br>
    <a href="../main/main.php">友達一覧ページに戻る</a>
    <?php include_once(ROOT_PATH. 'Views/main/main_footer.php'); ?>
  </body>
  </html>
