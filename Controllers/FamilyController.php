<?php
require_once (ROOT_PATH. 'Models/Db.php');
require_once (ROOT_PATH. 'Models/Validate.php');
require_once (ROOT_PATH. 'Models/Users.php');
require_once (ROOT_PATH. 'Models/post_Validate.php');
require_once (ROOT_PATH. 'Models/UsersPost.php');
require_once (ROOT_PATH. 'Models/Post.php');

class FamilyController {
  private $request;
  private $Validation;
  private $Users;
  private $post_Validation;
  private $UsersPost;
  private $Post;

  public function __construct() {
    //リクエストパラメータの取得
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;
    $this->request['file'] = $_FILES;
    //モデルオブジェクトの生成
    $this->Validation = new Validation();
    $this->Users = new Users();
    $this->post_Validation = new post_Validation();
    $this->UsersPost = new UsersPost();
    $this->Post = new Post();
  }

  //新規登録のバリデーション
  public function userValidate() {
    if(empty($this->request['post'])) {
      echo '指定されたパラメータが不明です。このページを表示できません';
      exit;
    }
    $checkBox = $this->request['post'];
    $err = $this->Validation->userValidation($checkBox);
    return $err;
  }

  //アカウント新規作成
  public function userCreate() {
    $userBox = $_SESSION['form'];
    $email = $userBox['email'];

    $result = $this->Users->Users_email($email);

    if(!empty($result)) {
      $_SESSION['limit_err'] = "メールアドレスが既に登録済みです。";
      $result = false;
      return $result;
    }
    $result = $this->Users->userAccount($userBox);
    return $result;
  }

  //ログインのバリデーション
  public function loginValidate() {
    if(empty($this->request['post'])) {
      echo '指定されたパラメータが不明です。このページを表示できません';
      exit;
    }
    $userBox = $this->request['post'];
    $err = $this->Validation->loginValidation($userBox);
    return $err;
  }

  //ユーザログイン
  public function userLogin() {
    $result = false;
    if(empty($this->request['post'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit;
    }
    $userBox = $this->request['post'];
    $email = $userBox['email'];
    $password = $userBox['password'];

    $user = $this->Users->Users_email($email);

    if(!$user) {
      $_SESSION['msg'] = 'emailが一致しません。';
      return $result;
    }

    if(password_verify($password,$user['password'])) {
      //ログイン成功
      if($user['role'] === 0) {
        $_SESSION['msg'] = '管理者は入れません。';
        return $result;
      }
      //一般ユーザであれば
      session_regenerate_id(true);
      $_SESSION['login_user'] = $user;

      $result = true;
      return $result;
    }

    $_SESSION['msg'] = 'パスワードが一致しません。';
    return $result;
  }

  public function mail_send_Validate() {
    if(empty($this->request['post'])) {
      echo '指定されたパラメータが不明です。このページを表示できません';
      exit;
    }

    $userBox = $this->request['post'];
    $err = $this->Validation->mail_send_Validation($userBox);
    return $err;
  }

  //パスワードの再発行
  public function mail_send() {
    $result = false;
    if(empty($this->request['post'])) {
      echo '指定されたパラメータが不明です。このページを表示できません';
      exit;
    }

    $userBox = $this->request['post'];
    $email = $userBox['email'];

    $user = $this->Users->Users_email($email);

    if(empty($user)) {
      $_SESSION['send_err'] = "入力したメールアドレスは登録されていません。";
      return $result;
    }

    $_SESSION['send_account'] = $user;
    $result = true;

    return $result;
  }

  //パスワード再発行の入力バリデーション
  public function pass_Reset_Validate() {
    if(empty($this->request['post'])) {
      echo '指定されたパラメータが不明です。このページを表示できません';
      exit;
    }

    $userBox = $this->request['post'];
    $err = $this->Validation->pass_Conf($userBox);

    return $err;
  }

  //パスワードリセットアクションを実行する
  public function pass_Reset() {
    if(empty($this->request['post'])) {
      echo '指定されたパラメータが不明です。このページを表示できません';
      exit;
    }

    $userBox = $this->request['post'];
    $email = $_SESSION['send_account']['email'];
    $password = $userBox['password'];

    $result = $this->Users->User_Pass_Reset($password,$email);
    return $result;
  }

  //ログイン状態かチェックする。
  public function checkLogin() {
    $result = $this->Validation->loginCheck();
    return $result;
  }

  //アカウント編集できる本人かチェックする。
  public function User_Check() {
    if(empty($this->request['post'])) {
      echo '指定されたパラメータが不明です。このページを表示できません';
      exit;
    }
    $sendBox = $this->request['post'];

    $err = $this->Validation->User_Check_Vd($sendBox);
    return $err;
  }

  public function User_Edit_Vd() {
    if(empty($this->request['post'])) {
      echo '指定されたパラメータが不明です。このページを表示できません';
      exit;
    }

    $userBox = $this->request['post'];

    $err = $this->Validation->M_User_Edit_Vd($userBox);
    return $err;
  }


  //アカウントの編集を行う
  public function User_UPdate() {
    if(empty($this->request['post'])) {
      echo '指定されたパラメータが不明です。このページを表示できません';
      exit;
    }
    $files = $this->request['file'];
    $image = uniqid(mt_rand(),true);
    $image .= '.'.substr(strrchr($files['image']['name'], '.'),1);
    $file = "./Family/img/$image";
    if(!empty($files['image']['name'])) {
      move_uploaded_file($files['image']['tmp_name'], './Family/img/'.$image);
    }
    //ファイルではない場合no_imageを挿入
    if(!exif_imagetype($file)) {
      $image = 'no_image.png';
    }
    $userBox = $this->request['post'];

    $result = $this->Users->User_UPdate_M($userBox,$image);

    return $result;
  }

  //アカウントのアップデート
  public function Account_UPdate() {
    $id = $_SESSION['login_user']['id'];

    $user = $this->Users->Account_Update($id);

    if(isset($user)) {
      session_regenerate_id(true);
      $_SESSION['login_user'] = $user;
    }
  }
  //ログアウトを行う
  public function logout() {
    $this->Users->logout();
  }





  //ポスト関連のコントロール
  public function Post_Validate() {
    if(empty($this->request['post'])) {
      echo '指定されたパラメータが不明です。このページを表示できません';
      exit;
    }
    $postBox = $this->request['post'];
    $err = $this->post_Validation->Post_Validation($postBox);

    return $err;

  }

  //ポストを新規作成して登録する
  public function Create_Post() {
    /*if(empty($_SESSION['create_files'])){
    echo '謎エラー発動';
    exit;
  }*/
  //echo var_dump($files);
  //exit;
  /*if(empty($files)) {
  echo '謎エラー発動';
  exit;
}*/

/*$image = uniqid(mt_rand(),true);
$image .= '.'.substr(strrchr($files['image']['name'], '.'),1);
$file = "./Family/img/$image";

//var_dump($files['image']['name']);
//exit;
if(!empty($files['image']['name'])) {
move_uploaded_file($files['image']['tmp_name'], './Family/img/'.$image);
}
//ファイルではない場合no_imageを挿入
if(!exif_imagetype($file)) {
$image = 'no_image.png';
}*/

$image = $_SESSION['image'];
$createBox = $_SESSION['create_form'];
$id = $_SESSION['login_user']['id'];

$result = $this->Post->CreatePost($createBox,$id,$image);
return $result;
}

//ユーザー情報を表示する。
public function Main_User_Post() {
  $page = 0;
  if(isset($this->request['get']['page'])) {
    $page = $this->request['get']['page'];
  }
  $id = $_SESSION['login_user']['id'];
  $post_count = $this->Post->countAll($id);
  $_SESSION['box'] = $post_count;
  $users = $this->Post->MainUserPost($id,$page);

  $params = [
    'users' => $users,
    'pages' => $post_count / 5,
  ];
  return $params;
}

//アカウントユーザーのポストを表示する。
public function Post_One() {
  if(empty($this->request['get'])) {
    echo '指定されたパラメータが不明です。このページを表示できません';
    exit;
  }
  $id = $this->request['get']['id'];
  session_regenerate_id(true);
  $_SESSION['view_id'] = $id;
  $userOne = $this->Post->PostOne($id);
  $params = [
    'userOne' => $userOne
  ];
  return $params;
}

//sessionからポスト情報を表示する
public function Post_One_id() {
  if(empty($_SESSION['view_id'])) {
    echo '不正アクセスですa。';
    exit;
  }

  $id = $_SESSION['view_id'];
  $userOne = $this->Post->PostOne($id);
  $params = [
    'userOne' => $userOne
  ];
  return $params;
}

//投稿を削除する
public function Post_Delete() {
  $id = $_SESSION['view_id'];
  $this->Post->PostDelete($id);
  return;
}

//投稿を編集する。
public function Post_Edit(){
  if(empty($this->request['post'])) {
    echo '指定されたパラメータが不明です。このページを表示できません';
    exit;
  }
  $files = $this->request['file'];

  $image = uniqid(mt_rand(),true);
  $image .= '.'.substr(strrchr($files['image']['name'], '.'),1);
  $file = "./Family/img/$image";
  if(!empty($files['image']['name'])) {
    move_uploaded_file($files['image']['tmp_name'], './Family/img/'.$image);
  }
  //ファイルではない場合no_imageを挿入
  if(!exif_imagetype($file)) {
    $image = 'no_image.png';
  }

  $userBox = $this->request['post'];
  $id = $_SESSION['view_id'];

  $this->Post->PostEdit($userBox,$id,$image);
  return;
}

//アカウントユーザ以外の投稿を表示する。
public function Post_Index() {
  if(empty($_SESSION['login_user'])) {
    echo '不正アクセス';
    exit;
  }

  $page = 0;
  if(isset($this->request['get']['page'])) {
    $page = $this->request['get']['page'];
  }

  $id = $_SESSION['login_user']['id'];
  $user = $this->Post->PostIndex($id);
  $pages = $this->Post->OtherPostCount($id);
  $params = [
    'user' => $user,
    'pages' => $pages / 5
  ];
  return $params;
}

//友達のポスト情報を表示する
public function friend_Post_One() {
  if(empty($this->request['get'])) {
    echo '指定されたパラメータが不明です。このページを表示できません';
    exit;
  }
  $id = $this->request['get']['id'];
  $userOne = $this->Post->PostOne($id);
  $params = [
    'userOne' => $userOne
  ];
  return $params;
}

//友達一覧を表示する。
public function Friend_index() {
  $id = $_SESSION['login_user']['id'];

  $friends = $this->Post->FriendIndex($id);
  $params = [
    'friends' => $friends
  ];
  return $params;
}

//友達の登録を解除する。
public function friend_Delete(){
  if(empty($this->request['post'])) {
    echo '指定されたパラメータが不明です。このページを表示できません';
    exit;
  }
  $user_id = $_SESSION['login_user']['id'];
  $friend_id = $this->request['post']['id'];
  $_SESSION['f_token'] = $friend_id;
  $this->Post->friendDelete($user_id,$friend_id);
  return;
}

//フレンドの名前だけ
public function friend_Name() {
  $id = $_SESSION['f_token'];
  $name = $this->Post->friendName($id);
  $params = [
    'name' => $name
  ];
  return $name;
}

//フレンド情報を表示する。
public function friend_One() {
  if(empty($this->request['post'])) {
    echo '指定されたパラメータが不明です。このページを表示できません';
    exit;
  }
  $id = $this->request['post']['id'];
  session_regenerate_id(true);
  $_SESSION['back_post'] = $id;
  $friendOne = $this->Post->friendOne($id);
  $friendPost = $this->Post->friendOne_post($id);
  $params = [
    'friendOne' => $friendOne,
    'friendPost' => $friendPost
  ];
  return $params;
}

//管理者のログインを行う
public function admin_Login() {
  $result = false;
  if(empty($this->request['post'])) {
    echo '指定のパラメータが不正です。このページを表示できません。';
    exit;
  }
  $post = $this->request['post'];
  $email = $post['email'];
  $password = $post['password'];

  $admin = $this->Users->Users_email($email);
  if(!$admin) {
    $_SESSION['ad_msg'] = 'emailが一致しません。';
    return $result;
  }
  if($admin['role'] === 1) {
    $_SESSION['ad_msg'] = 'emailが一致しません';
    return $result;
  }
  if($password == $admin['password']) {
    session_regenerate_id(true);
    $_SESSION['admin_user'] = $admin;

    $result = true;
    return $result;
  }

  $_SESSION['ad_msg'] = 'パスワードが一致しません。';
  return $result;
}

//管理者以外のアカウントを表示する
public function User_index() {
  $id = $_SESSION['admin_user']['id'];

  $user = $this->Post->Userindex($id);
  $params = [
    'user' => $user
  ];
  return $params;
}

//管理者画面で選択したユーザを表示
public function user_One() {
  if(empty($this->request['get'])) {
    echo '指定されたパラメータが不明です。このページを表示できません';
    exit;
  }
  $id = $this->request['get']['id'];
  $userOne = $this->Post->userOne($id);
  $params = [
    'userOne' => $userOne
  ];
  return $params;
}

//ユーザ情報を削除する
public function user_delete() {
  if(empty($this->request['post'])) {
    echo '指定されたパラメータが不明です。このページを表示できません';
    exit;
  }
  $id = $this->request['post']['id'];
  $this->Users->userDelete($id);
  return;
}

public function good_data(){
  if(empty($this->request['post'])) {
    echo '指定されたパラメータが不明です。このページを表示できません';
    exit;
  }
  $p_id = $this->request['post']['postId'];
  $u_id = $_SESSION['login_user']['id'];

  $count = $this->UsersPost->gooddata($p_id,$u_id);
  return $count;
}

public function friend_Register() {
  if(empty($this->request['post'])) {
    echo '指定されたパラメータが不明です。このページを表示できません';
    exit;
  }
  $u_id = $_SESSION['login_user']['id'];
  $f_id = $this->request['post']['friendId'];

  $result = $this->UsersPost->friendRegister($u_id,$f_id);
  return $result;
}

public function goodUser_Check() {
  if(empty($this->request['get'])) {
    echo '指定されたパラメータが不明です。このページを表示できません';
    exit;
  }
  $u_id = $_SESSION['login_user']['id'];
  $p_id = $this->request['get']['id'];

  $result = $this->UsersPost->goodUserCheck($u_id,$p_id);
  return $result;
}

//カウント数を表示する
public function good_Count() {
  if(empty($this->request['get'])) {
    echo '指定されたパラメータが不明です。このページを表示できません';
    exit;
  }
  $p_id = $this->request['get']['id'];

  $count = $this->UsersPost->countGood($p_id);
  return $count;
}

public function friend_Check() {
  if(empty($this->request['get'])) {
    echo '指定されたパラメータが不明です。このページを表示できません';
    exit;
  }
  $u_id = $_SESSION['login_user']['id'];
  $id = $this->request['get']['id'];
  $friend = $this->UsersPost->Post_in_User($id);
  $f_id = $friend['user_id'];

  $result = $this->UsersPost->friendCheck($u_id,$f_id);
  return $result;
}
}
