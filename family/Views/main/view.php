<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
require_once (ROOT_PATH. 'function.php');
$view = new FamilyController();
//ログインチェック
$result = $view->checkLogin();
//ポストデータの表示
$params = $view->Post_One();

if(!$result) {
  $_SESSION['login_err'] = 'ユーザーアカウントを登録してください!';
  header('Location: ../login/login.php');
  return;
} ?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <?php include_once(ROOT_PATH.'Views/main/main_header.php');?>
  <div class="friend_post_box">
    <div class="user_info_border">

      <!--プレイヤー情報を表示-->
      <?php if(isset($params)):?>
        <?php $userOne = $params['userOne'];?>
      <?php endif;?>

      <div class="post_title">
        <h3>タイトル:<?=h($userOne['title'])?></h3>
      </div>

      <div class="user_info">
        <table>
          <tr>
            <td>投稿日:<?=$userOne['created_at']?></td>
          </tr>
          <tr>
            <td>いいね数:<?=$userOne['hownice']?></td>
            <tr>
              <td>更新日:<?=$userOne['updated_at']?></td>
            </tr>
          </table>
        </div>
      </div>

      <div class="user_post_info">
        <div class="post_text_area">
          <?= nl2br(h($userOne['text']))?>
        </div>
      </div>
      <div class="edit_back">
        <form action="../edit_delete/edit.php" method="post" id="post_edit_Btn">
          <input type="submit" name="edit" value="編集する">
        </form>
        <form action="../edit_delete/delete_confirm.php" method="post" id="post_delete_Btn">
          <input type="submit" name="delete" value="削除する">
        </form>
      </div>
      <div class="view_back">
        <a href="main.php">メインページに戻る</a>
      </div>
      <?php include_once(ROOT_PATH.'Views/main/main_footer.php'); ?>
    </body>
    </html>
