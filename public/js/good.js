$(function(){
  var $good = $('.td-good'),goodPostId;//投稿id

  $good.on('click',function(e){
    e.stopPropagation();
    var $this = $(this);
    //カスタム属性(postid)に格納された投稿ID取得
    goodPostId = $this.parents('.td-good-post').data('postid');
    $.ajax({
      type: 'POST',
      url: '../friends/good.php',//post通信を受け取るphpファイル
      data:{postId:goodPostId},
    }).done(function(data){
      console.log('Ajax success');

      //いいねの総数を表示
      $this.children('span').html(data);
      //いいね取り消しのスタイル
      //$this.children('i').toggleClass('far');//空洞ハート
      //いいね押した時のスタイル
      //$this.children('i').toggleClass('fas');//塗りつぶしハート
      $this.children('i').toggleClass('active');
      $this.toggleClass('active');
    }).fail(function(msg){
      console.log('Ajax Error');
    });
  });
});
