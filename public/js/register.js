$(function(){
  var $regi = $('.td-register'),friendRegisterId;

  $regi.on('click',function(e){
    e.stopPropagation();
    var $this = $(this);
    //カスタム属性(friendid)のID取得
    friendRegisterId = $this.parents('.td-register-box').data('friendid');
    $.ajax({
      type: 'POST',
      url: '../friends/register.php',
      data: {friendId:friendRegisterId},
    }).done(function(data){
      console.log('Ajax success');

      $this.children('span').html(data);
      $this.children('i').toggleClass('active2');
      $this.toggleClass('active2');
    }).fail(function(msg){
      console.log('Ajax.Error');
    });
  });
});
