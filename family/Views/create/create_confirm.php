<?php
session_start();
require_once (ROOT_PATH. 'function.php');
require_once (ROOT_PATH. 'Controllers/FamilyController.php');
$confirm = new FamilyController();

if(!empty($_POST)) {
  $err = $confirm->Post_Validate();

  if(isset($err) && $err === true) {
    $_SESSION['create_form'] = $_POST;
    $files = $_FILES;

    $image = uniqid(mt_rand(),true);
    $image .= '.'.substr(strrchr($files['image']['name'], '.'),1);
    $file = "./Family/img/$image";

    if(!empty($files['image']['name'])) {
      move_uploaded_file($files['image']['tmp_name'], './Family/img/'.$image);
    }
    //ファイルではない場合no_imageを挿入
    if(!exif_imagetype($file)) {
      $image = 'no_image.png';
      $_SESSION['image'] = $image;
    }else {
      $_SESSION['image'] = $image;
    }

  } else if(isset($err) && $err !== true){
    $_SESSION['create_err'] = $err;
    header("Location: ../create/create_post.php");
    exit;
  }
}

if(isset($_SESSION['create_files'])) {
  $create_files = $_SESSION['create_files'];
}
if(isset($_SESSION['create_form'])) {
  $create_form = $_SESSION['create_form'];
}
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
    <div class="create_confirm_h3">
      <h3>この投稿内容で登録してもよろしいですか</h3>
    </div>
    <?php //var_dump($_SESSION['create_files']);?>
    <?php //var_dump($_FILES);?>
    <?php //var_dump($create_files);?>

    <div class="create_confirm_dd">
      <dl>
        <dt><label>タイトル</label></dt>
        <div class="create_confirm_dd_area">
          <dd><?php if(isset($create_form['title'])): ?>
            <?=h($create_form['title'])?>
          <?php endif;?>
        </dd>
      </div>
    </div>
    <div class="create_confirm_dd">
      <dt><label>投稿内容</label></dt>
      <div class="create_confirm_dd_area">
        <dd>
          <?php if(isset($create_form['text'])): ?>
            <?= nl2br(h($create_form['text'])) ?>
          <?php endif;?>
        </dd>
      </dl>
    </div>
  </div>

  <div class="create_or_back">
    <form action="create_complete.php" me+thod="post">
      <input type="submit" id="create_post_Btn" name="create" value="登録する">
    </form>
    <a href="javascript:history.back();">戻る</a>
  </div>
</main>
<?php include_once(ROOT_PATH. 'Views/main/main_footer.php'); ?>
</body>
</html>
