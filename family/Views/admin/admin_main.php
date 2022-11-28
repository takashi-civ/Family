<?php
session_start();
require_once(ROOT_PATH. 'Controllers/FamilyController.php');
$admin = new FamilyController();

$params = $admin->User_index();
$user = $params['user'];?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/admin-style.css">
</head>
<body>
  <?php include_once(ROOT_PATH.'Views/admin/admin_header.php');?>

  
  <main>
    <div class="post_list_box">
      <div class="list_head_h3">
        <h3>すべてのアカウント</h3>
      </div>
      <div class="logout">
        <a href ="../login/logout.php">ログアウトしてログインページに戻る</a>
      </div>

      <?php// var_dump($_SESSION['admin_user']);?>
      <?php //var_dump($user);?>
      <?php if(isset($user)) :?>
        <?php foreach($user as $users) :?>

          <div class="user_post_list">
            <div class="user_account_flex">

              <div class="user_delete">
                <table>
                  <tr><th>ID:</th><td><?=$users['id']?></td></tr>
                  <tr><th>ユーザネーム:</th><td><?=$users['name']?></td></tr>
                  <tr><th>メールアドレス:</th><td><?=$users['email']?></td></tr>
                </table>
                <div class="user_delete_Btn">
                  <form action="admin_delete_confirm.php" method="get">
                    <input type="hidden" name="id" value="<?=$users['id']?>">
                    <input type="submit" id="user_delete_Btn" value="削除する">
                  </form>
                </div>
              </div>

            </div>
          </div>
        <?php endforeach;?>
      <?php endif;?>

    </div>
  </main>
  <?php include_once(ROOT_PATH . 'Views/admin/admin_footer.php'); ?>
</body>
</html>
