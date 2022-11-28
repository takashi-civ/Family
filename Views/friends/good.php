<?php
session_start();
require_once (ROOT_PATH.'Controllers/FamilyController.php');
$good = new FamilyController;

if(isset($_POST['postId'])){

  $count = $good->good_data();
}

//if(isset($count)){
echo $count;
//}
