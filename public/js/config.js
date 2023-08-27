// トップ画面
// liをクリックすればformが変動

$(".theme_li").each(function(index,elem){
  $(elem).click(function(){
    $(".config_form").css("display","none")
    $(".config_form").eq(index).css("display","block")
  });
});