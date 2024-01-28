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

  // moveの現在大テーマ
  $("#move_before_theme_select").change((e)=>{

    // まず全ての表示を消す
    $(".now_choice_move_theme_default").css("display","none");
    $(".now_choice_move_theme").css("display","none");
    
    // 該当の大テーマのみ表示
    $(".now_choice_move_theme").each((index,elem)=>{
      if($(elem).data("id")===parseInt(e.currentTarget.value)){
        $(elem).css("display","block");
    }
   });
  })



})