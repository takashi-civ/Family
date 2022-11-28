<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');

$logout = new FamilyController();

if(empty($_SESSION['admin_user'])) {
  $result = $logout->checkLogin();
}

if($result === false) {
  $_SESSION['login_err'] = 'セッションが切れているか、ログインされていません。';
  header('Location: ../login/signup.php');
  return;

}

$logout->logout();
header('Location:../login/login.php');
