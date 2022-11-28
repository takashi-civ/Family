<?php
session_start();
require_once(ROOT_PATH. 'Controllers/FamilyController.php');
require_once(ROOT_PATH. 'function.php');
$main = new FamilyController();
$params = $main->Main_User_Post();

$result = $main->checkLogin();
if(!$result) {
  $_SESSION['login_err'] = 'ユーザーアカウントを登録してください!';
  header('Location: ../login/login.php');
  return;
}


$user_data = $_SESSION['login_user'];
unset($_SESSION['view_id']);
unset($_SESSION['e_token']);
?>



<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<main>
  <body>
    <?php include_once('main_header.php');?>
    <div class="user_account_box">
      <div class="user_account_view">
        <h3>アカウント情報</h3>

        <div class="user_account_flex">
          <div class="user_image_box">
            <a href="user_check.php"><img src="../Family/img/<?=$user_data['image']?>"></a>
          </div>

          <div class="user_account_detail">
            <table>
              <tr><th>ユーザーネーム:</th><td><?= h($user_data['name'])?></td></tr>
              <tr><th>メールアドレス:</th><td><?= h($user_data['email'])?></td></tr>
              <tr><th>友達:</th><td></td></tr>
              <tr><th>子供の数:</th><td>男の子<?= $user_data['male']?>人、女の子<?= $user_data['female']?>人</td></tr>
            </table>
            <div class="user_account_detail_Btn">
              <form action="user_check.php" method="post">
                <input type="submit" id="user_account_Btn" value="編集する">
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="post_list_box">
        <div class="list_head_h3">
          <h3>書いた投稿一覧</h3>
        </div>
        <?php //var_dump($_SESSION['box']);?>

        <?php foreach($params['users'] as $users): ?>
          <div class="user_post_list">
            <div class="user_account_flex">
              <div class="user_image_box">
                <a href="view.php?id=<?=$users['id']?>"><img src="../Family/img/<?=$users['post_image']?>"> </img></a>
              </div>
              <div class="user_post_detail">
                <table>
                  <tr><th>タイトル:</th><td><?=$users['title']?></td></tr>
                  <tr><th>投稿日時:</th><td><?=$users['created_at']?></td></tr>
                  <tr><th>更新日時:</th><td><?=$users['updated_at']?></td></tr>
                  <tr><th>いいねの数:</th><td><?=$users['hownice']?></td></tr>
                </table>
                <div class="user_post_detail_Btn">
                  <form action="view.php?id=<?=$users['id']?>" method="post">
                    <input type="hidden" name="id" value="<?=$users['id']?>">
                    <input type="submit" id="user_account_Btn" value="詳細">
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

        <div class ='paging'>
          <?php
          for($i=0;$i<=$params['pages'];$i++) {
            if(isset($_GET['page']) && $_GET['page'] == $i) {
              echo $i+1;
            } else {
              echo "<a href='?page=".$i."'>".($i+1)."</a>";
            }
          } ?>
        </div>

      </div>
    </main>
    <?php include_once('main_footer.php'); ?>
  </body>
  </html>
