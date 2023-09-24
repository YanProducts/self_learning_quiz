// トップページ

$(()=>{
  // liをクリックすればoptionが動く
  
  $(".first_li").each(function(index,elem){
    $(elem).click(function(){
      $(".first_li").removeClass("first_li_click")
      $(".first_option").eq(index).prop("selected",true);
      $(this).addClass("first_li_click")
    });
  });

})