<?php
session_start();
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
$login = new FamilyController();

if(!empty($_POST)) {
  $validate = $login->loginValidate();

  if(isset($validate) && $validate = true) {
    $result = $login->admin_Login();
    if($result === true) {
      header('Location: ../admin/admin_main.php');
    }
  } else {
    $err = $validate;
  }
}

if(isset($_SESSION['ad_msg'])) {
  $ad_err = $_SESSION['ad_msg'];
}

unset($_SESSION['ad_msg']);

?>
<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/admin-style.css">
</head>
<body>
  <?php include_once(ROOT_PATH.'Views/login/login_header.php'); ?>
  <main>

    <div class="admin_h2">
      <h2>管理者ログイン</h2>
    </div>
    <?php if(isset($err)) : ?>
      <?php foreach($err as $error) :?>
        <?= '<p>'.$error.'</p>'?>
      <?php endforeach;?>
    <?php endif;?>

    <?php if(isset($ad_err)) :?>
      <?= '<p>'.$ad_err.'</p>'?>
    <?php endif;?>

    <div class="ad_form">
      <div class="form_case">
        <form action="../admin/admin_log.php" method="POST" >
          <div><input type="email" name="email" placeholder="メールアドレス"></div>

          <div><input type="password" name="password" placeholder="パスワード"></div>

          <div><input type="submit" id="login_button" name="login_button" value="ログイン"></div>
        </form>
        <div class="login_entrance"><a href ="../login/login.php">一般ログインに戻る</a></div>
      </div>
    </div>

  </main>
</body>
</html>
<?php include_once(ROOT_PATH.'Views/login/login_footer.php'); ?>
