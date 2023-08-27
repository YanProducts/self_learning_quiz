// トップ画面
// liをクリックすればoptionが動く

$(".first_li").each(function(index,elem){
  $(elem).click(function(){
    $(".first_option").eq(index).prop("selected",true);
  });
});