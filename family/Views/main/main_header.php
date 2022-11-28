

<header>
  <div class="main-header">
    <h1>
      <a href= "../main/main.php">Family</a>
    </h1>

    <nav class="main-header-nav">
      <ul>
        <li><a href="../main/main.php">メインページ</a></li>
        <li><a href="../create/create_post.php">記事を書く</a></li>
        <li><a href="../friends/friends_post_index.php">友達一覧</a></li>
        <li><a href="../friends/post.php">他の投稿</a></li>
        <li><a href="../login/logout.php" onclick="return check()">ログアウト</a></li>
      </ul>
    </nav>

    <script>
    function check() {
      if(window.confirm("ログアウトしますか？")) {
        return true;

      }else {
        return false;
      }
    }
  </script>
</header>
