<?php
session_start();
require_once (ROOT_PATH.'Controllers/FamilyController.php');
$register = new FamilyController;

if(isset($_POST['friendId'])) {
  $result = $register->friend_Register();
}

if(isset($result) && $result === true) {
  echo '登録済み';
}else {
  echo '未登録';
}
