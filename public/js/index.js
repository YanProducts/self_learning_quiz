// トップページ

$(()=>{
  // liをクリックすればoptionが動く
  
  $(".first_li").each(function(index,elem){
    $(elem).click(function(){
      $(".first_li").removeClass("first_li_click")
      $(".first_option").eq(index).prop("selected",true);
      $(this).addClass("first_li_click");
    });
  });

// 何も選択されていない時は返す
  $("#index_btn").click((e)=>{
    e.preventDefault();
    if($("#type_select").val()==="nothing"){
      alert("選択されていません");
      return;
    }else{
      $("#what_you_do").submit();
    }
  })


})