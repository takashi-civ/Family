<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
$user_friends = new FamilyController();

$log_result = $user_friends->checkLogin();
if(!$log_result) {
  $_SESSION['login_err'] = 'ユーザーアカウントを登録してください!';
  header('Location: ../login/login.php');
  return;
}

$params = $user_friends->Friend_index();
$friend = $params['friends'];

?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <script type="text/javascript" src="../js/click.js"></script>
</head>
<body>
  <?php include_once(ROOT_PATH. 'Views/main/main_header.php');?>

  <main>

    <div class="friend_user_list_box">
      <div class="list_head_h3">
        <h3>友達一覧</h3>
      </div>

      <?php if(isset($friend)): ?>
        <?php foreach($friend as $friends): ?>

          <div class="friend_user_list">
            <div class="user_account_flex">
              <div class="user_image_box">
                <a href="user_check.php"><img src="../Family/img/<?=$friends['image']?>" alt="image"></a>
              </div>
              <div class="user_post_detail">
                <table>
                  <tr><th>ユーザーネーム:</th><td><?=$friends['name']?></td></tr>
                  <tr><th>入会日:</th><td><?=$friends['created_at']?></td></tr>
                  <tr><th>子供の数:</th><td>男の子<?=$friends['male']?>人、女の子<?=$friends['female']?>人</td></tr>
                </table>
                <div class="user_post_detail_Btn">
                  <form action="friend_one.php" method="post">
                    <input type="hidden" name="id" value="<?=$friends['id']?>">
                    <input type="submit" id="user_account_Btn" value="詳細">
                  </form>
                </div>
              </div>
              <div class="friends_delete_form">
                <form action="friend_delete.php" method="post" onsubmit="return Delete()">
                  <input type="hidden" name="id" value="<?=$friends['id']?>">
                  <input type="submit" id="friends_delete_Btn" value="友達解除">
                </form>
              </div>

            </div>
          </div>
        <?php endforeach;?>
      <?php endif;?>
    </div>
  </main>
  <?php include_once(ROOT_PATH . 'Views/main/main_footer.php'); ?>
</body>
</html>
