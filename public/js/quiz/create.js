// 作成ページ

$(()=>{
  // テーマ選択でhiddenのselectが動く
  $(".quiz_create_each_theme").each((index,elem)=>{
    $(elem).click(()=>{
      if(!$(".quiz_create_hidden_option").eq(index).prop("selected")){
        $(elem).css("background-color","skyblue");
        $(".quiz_create_hidden_option").eq(index).prop("selected",true);
      }else{
        $(elem).css("background-color","white");
        $(".quiz_create_hidden_option").eq(index).prop("selected",false);
      }
     })
  })

})