<?php
require_once (ROOT_PATH. 'Models/Db.php');

class Validation {
  public function userValidation($checkBox) {
    //名前のチェック
    if($checkBox['name'] === '') {
      $err['name'] = '氏名の入力は必須です。';
    }

    //メールアドレスのチェック
    if(empty($checkBox['email'])) {
      $err['email'] = "メールアドレスの入力は必須です。";
    }

    //パスワードのチェック
    if(empty($checkBox['password'])) {
      $err['password1'] = 'パスワードの入力は必須です。';
    }

    $password = $checkBox['password'];

    //パスワードの文字チェック
    if(!preg_match("/\A[a-z\d]{8,16}+\z/i",$password)) {
      $err['password2'] = 'パスワードは英数字8文字以上16文字以下で入力してください。';
    }

    if(empty($err)) {
      $err = true;
    }
    return $err;
  }

  //ログインバリテーション
  public function loginValidation($userBox) {
    //メールアドレスのチェック
    if(empty($userBox['email'])) {
      $err['email'] = "メールアドレスの入力は必須です。";
    }
    if(empty($userBox['password'])) {
      $err['password'] = "パスワードの入力は必須です。";
    }

    if(empty($err)) {
      $err = true;
    }
    return $err;
  }

  public function mail_send_Validation($userBox) {
    if(empty($userBox['email'])) {
      $err['email'] = "メールアドレスを入力してください。";
    }

    if(empty($err)) {
      $err = true;
    }
    return $err;
  }


  public function pass_Conf($userBox) {
    //パスワード入力チェック
    if(empty($userBox['password'])) {
      $err[] = "パスワードを入力してください。";
    }

    $password = $userBox['password'];

    if(!preg_match("/\A[a-z\d]{8,16}+\z/i",$password)) {
      $err[] = 'パスワードは英数字8文字以上16文字以下にしてください';
    }


    $password_conf = $userBox['password_conf'];

    if($password !== $password_conf) {
      $err[] = "確認用パスワードと異なってます。";
    }

    if(empty($err)) {
      $err = true;
    }
    return $err;
  }

  //ログイン状態かチェックする。
  public function loginCheck() {
    $result = false;
    if(isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0) {
      if($_SESSION['login_user']['role'] == 0) {
        return $result;
      }
      $result = true;
      return $result;
    }
    return $result;
  }

  //ユーザー情報と一致しているか調べる
  public function User_Check_Vd($sendBox) {
    $userBox = $_SESSION['login_user'];

    if(empty($sendBox['email'])) {
      $err['email'] = "メールアドレスの入力は必須です。";
    }

    if(empty($sendBox['password'])) {
      $err['password'] = "パスワードの入力は必須です。";
    }

    if($sendBox['email'] !== $userBox['email']) {
      $err['match'] = "メールアドレスかパスワードが一致していません。";
    }

    if(!password_verify($sendBox['password'],$userBox['password'])) {
      $err['match'] = "メールアドレスかパスワードが一致していません。";
    }

    if(empty($err)) {
      $err = true;
    }
    return $err;
  }

  public function M_User_Edit_Vd($userBox) {

    if(empty($userBox['name'])) {
      $err['name'] = "ユーザーネームの入力は必須です。";
    }

    if(empty($err)) {
      $err = true;
    }
    return $err;
  }


}?>
