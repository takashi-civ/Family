<?php
require_once (ROOT_PATH. 'Models/Db.php');

class Post extends Db {
  private $table = 'post';
  public function __construct($dbh = null) {
    parent:: __construct($dbh);
  }

  public function CreatePost($createBox,$id,$image) {
    $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->dbh->beginTransaction();

    $result = false;
    //ポストテーブルに挿入する
    $sql = "INSERT INTO post (user_id, post_image, title, `text`)";
    $sql .= " VALUE (:user_id, :post_image, :title, :text)";

    try {
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':user_id',$id,PDO::PARAM_INT);
      $stmt->bindParam(':post_image',$image,PDO::PARAM_STR);
      $stmt->bindParam(':title',$createBox['title'],PDO::PARAM_STR);
      $stmt->bindParam(':text',$createBox['text'],PDO::PARAM_STR);
      $stmt->execute();
      //user_postの削除
      $this->dbh->commit();

      $result = true;
      return $result;

    } catch (\Exception $e) {
      $this->dbh->rollBack();
      return $result;
    }
  }

  //メインページにアカウント本人のポストデータを表示する。
  public function MainUserPost($id,$page = 0) {
    //データベースから自分のポストデータを表示する。
    $sql = 'SELECT * FROM post WHERE user_id = :id ';
    $sql .= 'LIMIT 5 OFFSET '.(5 * $page);
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }


  //ページを作る
  public function countAll($id) {
    $sql = 'SELECT count(*) as count FROM post WHERE user_id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id',$id,PDO::PARAM_INT);
    $sth->execute();
    $count = $sth->fetchColumn();
    return $count;
  }

  //ポストデータを一つだけ表示する
  public function PostOne($id) {
    //ポストデータをidで引っ張る
    $sql = 'SELECT p.*, u.name as name FROM post p JOIN users u ON p.user_id = u.id WHERE p.id = :id';
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    $stmt->execute();
    $userOne = $stmt->fetch(PDO::FETCH_ASSOC);
    return $userOne;

  }

  //ポストデータを削除する
  public function PostDelete($id) {

    $sql = 'DELETE FROM post WHERE id = :id';
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    $stmt->execute();

    return;
  }

  //投稿内容の編集
  public function PostEdit($userBox,$id,$image) {

    $sql = "UPDATE post SET post_image = :post_image, title = :title, `text` = :text ";
    $sql .= "WHERE id = :id";

    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':post_image',$image,PDO::PARAM_STR);
    $stmt->bindParam(':title',$userBox['title'],PDO::PARAM_STR);
    $stmt->bindParam(':text',$userBox['text'],PDO::PARAM_STR);
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);

    $stmt->execute();
    return;
  }

  //アカウントユーザ以外の投稿を表示する
  public function PostIndex($id,$page = 0) {

    $sql = 'SELECT p.*, u.name as name FROM post p ';
    $sql .= 'JOIN users u ON p.user_id = u.id WHERE NOT user_id = :id ';
    $sql .= 'ORDER BY p.hownice DESC ';
    $sql .= 'LIMIT 5 OFFSET ' . (5 * $page);
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $user;
  }

  //アカウントユーザ以外の投稿をカウントする
  public function OtherPostCount($id) {

    $sql = 'SELECT count(*) as count FROM post WHERE NOT user_id = :id';
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count;
  }

  //友達のアカウントデータを表示
  public function FriendIndex($id) {

    $sql = 'SELECT * FROM users WHERE id = ';
    $sql .= 'ANY(SELECT friend_id FROM friends WHERE user_id = :id)';

    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    $stmt->execute();
    $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $friends;
  }

  public function friendDelete($user_id,$friend_id){

    $sql = 'DELETE FROM friends WHERE user_id = :user_id AND friend_id = :friend_id';
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':user_id',$user_id,PDO::PARAM_INT);
    $stmt->bindParam(':friend_id',$friend_id,PDO::PARAM_INT);
    $stmt->execute();
    return;
  }

  //フレンドの名前だけ
  public function friendName($id){

    $sql = 'SELECT name FROM users WHERE id = :id';

    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    $stmt->execute();

    $name = $stmt->fetch(PDO::FETCH_ASSOC);
    return $name;
  }

  //フレンド情報の表示
  public function friendOne($id) {
    $sql = 'SELECT * FROM users WHERE id = :id';

    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    $stmt->execute();

    $friendOne = $stmt->fetch(PDO::FETCH_ASSOC);
    return $friendOne;
  }

  //フレンドのポスト情報を表示
  public function friendOne_post($id) {
    $sql = 'SELECT * FROM post WHERE user_id = :id';

    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    $stmt->execute();

    $friendPost = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $friendPost;
  }

  //管理者以外のユーザを表示する
  public function Userindex($id) {

    $sql = 'SELECT * FROM users WHERE NOT id = :id AND role = 1';
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $user;
  }
  //ユーザ情報を一人だけ表示する
  public function userOne($id) {
    $sql = 'SELECT * FROM users WHERE id = :id';
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
  }
}
