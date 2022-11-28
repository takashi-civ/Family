function Delete(){
  if(window.confirm("本当に削除していいですか？")){
    return true;
  } else {
    window.alert("削除を中止しました。");
    return false;
  }
};

$(function(){
  $('#image').on('change', function (e) {
     var reader = new FileReader();
     reader.onload = function (e) {
         $("#myImage").attr('src', e.target.result);
     }
     reader.readAsDataURL(e.target.files[0]);
  });
});
