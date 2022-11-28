<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
require_once (ROOT_PATH. 'function.php');
$post = new FamilyController();
$params = $post->friend_Post_One();
$postCheck = $post->goodUser_Check();
$count = $post->good_Count();
$friendCheck = $post->friend_Check();
$userOne = $params['userOne'];

$log_result = $post->checkLogin();
if(!$log_result) {
  $_SESSION['login_err'] = 'ユーザーアカウントを登録してください!';
  header('Location: ../login/login.php');
  return;
}
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <script src="https://kit.fontawesome.com/dee855c0fb.js" crossorigin="anonymous"></script>
  <script src="../js/jquery.min.js"></script>
  <script type="text/javascript" src="../js/good.js"></script>
  <script type="text/javascript" src="../js/register.js"></script>

</head>
<body>
  <?php include_once(ROOT_PATH.'Views/main/main_header.php');?>
  <main>
    <div class="friend_post_box">
      <div class="user_info_border">
        <div class="post_title">
          <h3>タイトル:<?=h($userOne['title'])?></h3>
          <td>ユーザネーム:<?=h($userOne['name'])?></td>
        </div>
        <div class="user_info">
          <table>
            <tr>
              <td>投稿日:<?=$userOne['created_at']?></td>
              <td class="flex">いいね数:<!--いいねをボタンで作る-->
                <section class="td-good-post" data-postid="<?= h($userOne['id'])?>">
                  <div class="td-good<?php if(isset($postCheck) && $postCheck === true){echo ' active';}?>">
                    <i class="fa-regular fa-heart<?php if(isset($postCheck) && $postCheck === true){echo ' active';}?>"></i>
                    <span><?= $count?></span>
                  </div>
                </section>
              </td>
            </tr>
            <tr>
              <td>更新日:<?=$userOne['updated_at']?></td>
              <td class="flex">友達:
                <section class="td-register-box" data-friendid="<?=h($userOne['user_id'])?>">
                  <div class="td-register<?php if(isset($postCheck) && $postCheck === true){echo ' active2';}?>">
                    <i class="fa-regular fa-star<?php if(isset($friendCheck) && $friendCheck === true){echo ' active2';}?>"></i>
                    <span><?php if(isset($friendCheck) && $friendCheck === true){echo '登録済み';}else{echo '未登録';}?></span>
                  </div>
                </section>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="user_post_info">
        <div class="post_text_area">
          <?=nl2br(h($userOne['text']))?>
        </div>
      </div>
      <div class="back">
        <a href="javascript:history.back();">戻る</a>
      </div>
    </main>
    <?php include_once(ROOT_PATH.'Views/main/main_footer.php'); ?>
  </body>
  </html>
