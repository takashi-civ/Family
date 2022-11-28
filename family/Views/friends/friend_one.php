<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
$friend = new FamilyController();
$params = $friend->friend_One();

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <?php include_once(ROOT_PATH.'Views/main/main_header.php');?>

  <main>
    <?php $One = $params['friendOne'];?>
    <div class="user_account_box">
      <div class="user_account_view">
        <h3>アカウント情報</h3>
        <div class="user_account_flex">
          <div class="user_image_box">
            <a href="#"><img src="../Family/img/<?php if(isset($One['post_image'])){echo $One['post_image'];}?>"></a>
          </div>

          <div class="user_account_detail">
            <table>
              <tr><th>ユーザーネーム:</th><td><?=$One['name']?></td></tr>
              <tr><th>メールアドレス:</th><td><?=$One['email']?></td></tr>
              <tr><th>子供の数:</th><td>男の子<?=$One['male']?>人、女の子<?=$One['female']?>人</td></tr>
            </table>
            <div class="user_account_detail_Btn">
              <form action="friends_post_index.php" method="post">
                <input type="submit" id="user_account_Btn" value="フレンド一覧">
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="user_post_list_box">
        <div class="list_head_h3">
          <h3>書いた投稿一覧</h3>
        </div>
        <?php $post = $params['friendPost']; ?>
        <?php foreach ($post as $posts): ?>
          <div class="user_post_list">
            <div class="user_account_flex">
              <div class="user_image_box">
                <a href="../friends/friend_one.php?id=<?=$posts['id']?>"><img src="../Family/img/<?=$posts['post_image']?>"></a>
              </div>

              <div class="user_post_detail">
                <table>
                  <tr><th>タイトル名:</th><td><?=$posts['title']?></td></tr>
                  <tr><th>投稿日:</th><td><?=$posts['created_at']?></td></tr>
                  <tr><th>更新日:</th><td><?=$posts['updated_at']?></td></tr>
                  <tr><th>いいね数:</th><td><?=$posts['hownice']?></td></tr>
                </table>
                <div class="user_post_detail_Btn">
                  <form action="friend_one_post.php?id=<?=$posts['id']?>" method="get">
                    <input type="hidden" name="id" value="<?=$posts['id']?>">
                    <input type="submit" id="user_account_Btn" value="詳細">
                  </form>
                </div>
              </div>

            </div>
          </div>
        <?php endforeach;?>
      </main>
      <?php include_once(ROOT_PATH.'Views/main/main_footer.php'); ?>
    </body>
    </html>
