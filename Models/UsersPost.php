<?php
require_once(ROOT_PATH. 'Models/Db.php');

class UsersPost extends Db {
  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  //いいねが登録されているか確認
  public function gooddata($p_id,$u_id) {
    try{
      $sql = 'SELECT count(*) FROM good WHERE user_id = :u_id AND post_id = :p_id';
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':p_id',$p_id,PDO::PARAM_INT);
      $stmt->bindParam(':u_id',$u_id,PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchColumn();
      //レコードが1件でもある場合
      if(!empty($result)){
        //レコードを削除する
        $sql = 'DELETE FROM good WHERE user_id = :u_id AND post_id = :p_id';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':p_id',$p_id,PDO::PARAM_INT);
        $stmt->bindParam(':u_id',$u_id,PDO::PARAM_INT);
        $stmt->execute();
        //削除した後にいいね数のカウント
        $count = $this->countGood($p_id);
        return $count;

      }else {
        //レコードを挿入する
        $sql = 'INSERT INTO good (user_id,post_id) VALUES (:u_id , :p_id)';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':u_id',$u_id,PDO::PARAM_INT);
        $stmt->bindParam(':p_id',$p_id,PDO::PARAM_INT);
        $stmt->execute();

        $count = $this->countGood($p_id);
        return $count;
      }
    } catch(Exception $e){
      echo 'SQLエラー';
      exit;
    }
  }

  //いいね数をだす
  public function countGood($p_id) {
    $sql = 'SELECT count(*) FROM good WHERE post_id = :p_id';
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':p_id',$p_id,PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    $this->hownice($p_id,$count);
    return $count;
  }

  //ポストテーブルにいいね数を上書きする
  public function hownice($p_id,$count) {
    $sql = 'UPDATE post SET hownice = :hownice WHERE id = :id';
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':hownice',$count,PDO::PARAM_INT);
    $stmt->bindParam(':id',$p_id,PDO::PARAM_INT);
    $stmt->execute();
  }

  public function friendRegister($u_id,$f_id) {
    $sql = 'SELECT count(*) FROM friends WHERE user_id = :u_id AND friend_id = :f_id';
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':u_id',$u_id,PDO::PARAM_INT);
    $stmt->bindParam(':f_id',$f_id,PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchColumn();

    if(!empty($result)) {
      $sql = 'DELETE FROM friends WHERE user_id = :u_id AND friend_id = :f_id';
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam('u_id',$u_id,PDO::PARAM_INT);
      $stmt->bindParam('f_id',$f_id,PDO::PARAM_INT);
      $stmt->execute();
      $f_result = false;
      return $f_result;

    }else {

      $sql = 'INSERT INTO friends (user_id,friend_id) VALUES (:u_id, :f_id)';
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':u_id',$u_id,PDO::PARAM_INT);
      $stmt->bindParam(':f_id',$f_id,PDO::PARAM_INT);
      $stmt->execute();
      $f_result = true;

      return $f_result;
    }
  }

  public function goodUserCheck($u_id,$p_id) {
    $sql = 'SELECT count(*) FROM good WHERE user_id = :u_id AND post_id = :p_id';
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':u_id',$u_id,PDO::PARAM_INT);
    $stmt->bindParam(':p_id',$p_id,PDO::PARAM_INT);
    $stmt->execute();
    $g_result = $stmt->fetchColumn();

    if(!empty($g_result)) {
      $result = true;
      return $result;

    }else {
      $result = false;
      return $result;
    }
  }

  public function friendCheck($u_id,$f_id) {
    $sql = 'SELECT count(*) FROM friends WHERE user_id = :u_id AND friend_id = :f_id';
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':u_id',$u_id,PDO::PARAM_INT);
    $stmt->bindParam(':f_id',$f_id,PDO::PARAM_INT);
    $stmt->execute();
    $f_result = $stmt->fetchColumn();

    if(!empty($f_result)) {
      $result = true;
      return $result;

    }else {
      $result = false;
      return $result;
    }
  }

  //ポスト情報からユーザIDがフレンドテーブルにあるかチェック
  public function Post_in_User($id) {
    $sql = 'SELECT * FROM post WHERE id = :id';
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    $stmt->execute();
    $friend = $stmt->fetch();
    return $friend;
  }


}
