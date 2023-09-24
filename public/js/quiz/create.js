// 作成ページ

$(()=>{
  // テーマ選択でhiddenのselectが動く
  $(".quiz_create_each_theme").each((index,elem)=>{
    console.log($(elem))
    $(elem).click(()=>{
      $(elem).css("background-color","skyblue");
      $(".quiz_create_hidden_option").eq(index).prop("selected",true);
      console.log($(".quiz_create_hidden_option").eq(index).prop("selected"));
      console.log($("#quiz_create_hidden_select").val())
    })
  })

})