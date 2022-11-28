<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
require_once (ROOT_PATH. 'function.php');
$post = new FamilyController();
$params = $post->friend_Post_One();
$postCheck = $post->goodUser_Check();
$count = $post->good_Count();
$userOne = $params['userOne'];
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <script src="https://kit.fontawesome.com/dee855c0fb.js" crossorigin="anonymous"></script>
  <script src="../js/jquery.min.js"></script>
  <script type="text/javascript" src="../js/good.js"></script>
</head>
<body>
  <?php include_once(ROOT_PATH.'Views/main/main_header.php');?>
  <main>
    <div class="friend_post_box">
      <div class="user_info_border">
        <div class="post_title">
          <h3>タイトル:<?=h($userOne['title'])?></h3>
          <td>ユーザネーム:<?=h($userOne['name'])?>
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
          <form action="friend_one.php" method="post">
            <input type="hidden" name="id" value="<?=$_SESSION['back_post']?>">
            <input type="submit" id="back_Btn" value="戻る">
          </form>
        </div>
      </main>
      <?php include_once(ROOT_PATH.'Views/main/main_footer.php'); ?>
    </body>
    </html>
