<?php
require_once (ROOT_PATH. 'Models/Users.php');

class post_Validation {

  //新規投稿のバリテーション
  public function Post_Validation($postBox) {
    if(empty($postBox['title'])) {
      $err['title'] = "タイトルの入力は必須です。";
    }

    if(empty($postBox['text'])) {
      $err['text'] = "記事内容の入力は必須です。";
    }

    if(empty($err)) {
      $err = true;
      return $err;
    }
    return $err;
  }
}
