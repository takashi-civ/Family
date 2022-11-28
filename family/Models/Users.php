<?php
require_once (ROOT_PATH. 'Models/Db.php');

class Users extends Db {
  private $table = 'users';
  public function __construct($dbh = null) {
    parent:: __construct($dbh);
  }

  //アカウント情報をインサートする。
  public function userAccount($userBox) {
    $this->dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $this->dbh->beginTransaction();

    $result = false;
    $sql = 'INSERT INTO users (name,email,password,image,male,female)
    VALUES (?,?,?,?,?,?)';

    //アカウントデータを挿入する
    $arr = [];
    $arr[] = $userBox['name'];
    $arr[] = $userBox['email'];
    $arr[] = password_hash($userBox['password'],PASSWORD_DEFAULT);
    $arr[] = 'no_image.png';
    $arr[] = $userBox['male'];
    $arr[] = $userBox['female'];

    try {
      $stmt = $this->dbh->prepare($sql);
      $result = $stmt->execute($arr);
      $this->dbh->commit();

      $result = true;
      return $result;

    } catch(\Exception $e){
      $this->dbh->rollBack();
      return $result;
    }
  }

  //メールアドレスでアカウント検索を行う
  public function Users_email($email) {
    $sql = 'SELECT * FROM users WHERE email = ? limit 1';

    //emailの値を入れる
    $arr = [];
    $arr[] = $email;

    try {
      $stmt = $this->dbh->prepare($sql);
      $stmt->execute($arr);
      //SQLの結果を返す
      $user = $stmt->fetch();
      return $user;

    } catch(\Exception $e) {
      return false;
    }
  }

  //アカウントのパスワードを変更する
  public function User_Pass_Reset($password, $email) {
    $result = false;

    $sql = 'UPDATE users SET password = ? WHERE email = ?';

    $arr = [];
    $arr[] = password_hash($password,PASSWORD_DEFAULT);
    $arr[] = $email;

    try {
      $stmt = $this->dbh->prepare($sql);
      $stmt->execute($arr);

      $result = true;
      return $result;

    } catch(\Exception $e) {
      return $result;
    }
  }

  //アカウント情報を上書きする
  public function User_UPdate_M($userBox,$image) {
    $result = false;

    $sql = 'UPDATE users SET image = :image, name = :name, male = :male, female = :female';
    $sql .= ' WHERE id = :id';

    try {
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':image',$image,PDO::PARAM_STR);
      $sth->bindParam(':name',$userBox['name'],PDO::PARAM_STR);
      $sth->bindParam(':male',$userBox['male'],PDO::PARAM_INT);
      $sth->bindParam(':female',$userBox['female'],PDO::PARAM_INT);
      $sth->bindParam(':id',$userBox['id'],PDO::PARAM_INT);
      $sth->execute();

      $result = true;
      return $result;

    } catch(\Exception $e) {
      return $result;
    }
  }

  //アカウントのログイン情報を変更する。
  public function Account_Update($id) {
    $sql = 'SELECT * FROM users WHERE id = :id';

    try {
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id',$id,PDO::PARAM_INT);
      $sth->execute();
      $user = $sth->fetch(PDO::FETCH_ASSOC);

      return $user;

    } catch(\Exception $e) {
      exit('SQLエラー Account_UPdate');
    }
  }

  //ユーザを一人削除する
  public function userDelete($id) {

    $sql = 'DELETE FROM users WHERE id = :id ';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id',$id,PDO::PARAM_INT);
    $sth->execute();

    $this->userDelete2($id);
    return;
  }

  //フレンドテーブルからユーザを削除
  public function userDelete2($id) {
    $sql = 'DELETE FROM friends WHERE user_id = :id or friend_id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id',$id,PDO::PARAM_INT);
    $sth->execute();

    $this->userDelete3($id);
    return;
  }

  //ユーザポストテーブルからユーザを削除
  public function userDelete3($id) {
    $sql = 'DELETE FROM good WHERE user_id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id',$id,PDO::PARAM_INT);
    $sth->execute();
    return;
  }
  //ログアウト処理を行う
  public function logout() {
    $_SESSION = array();
    session_destroy();
  }

}
