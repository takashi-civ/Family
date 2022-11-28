<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
require_once (ROOT_PATH. 'function.php');
$post = new FamilyController();
$params = $post->Post_Index();

$log_result = $post->checkLogin();
if(!$log_result) {
  $_SESSION['login_err'] = 'ユーザーアカウントを登録してください!';
  header('Location: ../login/login.php');
  return;
}

$user = $params['user'];?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <?php include_once(ROOT_PATH.'Views/main/main_header.php');?>


  <main>
    <div class="post_list_box">
      <div class="list_head_h3">
        <h3>投稿一覧</h3>
      </div>

      <?php //var_dump($user);?>
      <?php foreach($user as $users) :?>

        <div class="user_post_list">
          <div class="user_account_flex">
            <div class="user_image_box">
              <a href="user_check.php"><img src="../Family/img/<?php if(isset($users)){echo $users['post_image'];}?>" alt="image"></a>
            </div>

            <div class="user_post_detail">
              <table>
                <tr><th>タイトル:</th><td><?php if(isset($users)){echo h($users['title']);}?></td></tr>
                <tr><th>ユーザネーム:</th><td><?php if(isset($users)){echo h($users['name']);}?></td></tr>
                <tr><th>投稿日時:</th><td><?php if(isset($users)){echo $users['created_at'];}?></td></tr>
                <tr><th>更新日時:</th><td><?php if(isset($users)){echo $users['updated_at'];}?></td></tr>
                <tr><th>いいねの数:</th><td><?php if(isset($users)){echo $users['hownice'];}?></td></tr>
              </table>
              <div class="user_post_detail_Btn">
                <form action="post_one.php" method="get">
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
  <?php include_once(ROOT_PATH . 'Views/main/main_footer.php'); ?>
</body>
</html>
