// 設定ページ

$(()=>{
  // liをクリックすればformが変動
  $(".theme_li").each(function(index,elem){
    $(elem).click(function(){
      $(".theme_li").removeClass("theme_li_click")
      $(".config_form").css("display","none");
      $(".config_form").eq(index).css("display","block");
      $(this).addClass("theme_li_click");
    });
  });
})