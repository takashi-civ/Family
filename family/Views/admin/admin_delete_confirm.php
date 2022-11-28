<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
require_once (ROOT_PATH. 'function.php');
$admin = new FamilyController();

$params = $admin->user_One();
$user = $params['userOne'] ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/admin-style.css">
</head>
<body>
  <?php include_once(ROOT_PATH.'Views/admin/admin_header.php');?>

  <main>
    <div class="delete_user_confirm_h3">
      <h3>こちらの投稿を削除しますか</h3>
    </div>
    <div class="delete_user_confirm_dd">
      <dl>
        <dt><label>ID</label></dt>
        <dd><?=h($user['id'])?></dd>
      </div>
      <div class="delete_user_confirm_dd">
        <dl>
          <dt><label>ユーザネーム</label></dt>
          <dd><?=h($user['name'])?></dd>
        </div>
        <div class="delete_user_confirm_dd">
          <dt><label>メールアドレス</label></dt>
          <dd><?=h($user['email'])?></dd>
        </dl>
      </div>

      <div class="delete_or_back">
        <form action="admin_delete_account.php" method="post">
          <input type="hidden" name="id" value="<?=$user['id']?>">
          <input type="submit" id="delete" name="delete" value="削除する">
        </form>
        <a href="javascript:history.back();">削除を中止する</a>
      </div>
    </main>
    <?php include_once(ROOT_PATH.'Views/admin/admin_footer.php'); ?>
  </body>
  </html>
