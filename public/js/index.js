// トップページなどに使用
// liでoption連動

$(()=>{

  // liをクリックするとoptionが動く
  
  const li_sets=[".first_li",".second_li"];
  const option_sets=[".first_option",".second_option"];

  for(let n=0;n<li_sets.length;n++){
    if($(li_sets[n]).length>0){
      $(li_sets[n]).each(function(index,elem){
        $(elem).click(function(){
          $(li_sets[n]).removeClass("first_li_click")
          $(option_sets[n]).eq(index).prop("selected",true);
          $(this).addClass("first_li_click");
          if($("#config_create_form").length>0){
            if(li_sets[n]===".first_li"){
            viewChangeWhenLiClick1(index);
            }else if(li_sets[n]===".second_li"){
            viewChangeWhenLiClick2(index);
            }
          }
        });
      });  
    }
  } 


// 何も選択されていない時は返す
// 
  if($("#index_btn").length>0){
    $("#index_btn").click((e)=>{
      e.preventDefault();
      if($("#type_select").val()==="nothing"){
        alert("選択されていません");
        return;
      }else{
        $("#what_you_do").submit();
      }
    })
  }


  // configのみ、ボタンに連動してul変更(新規)
  function viewChangeWhenLiClick1(index){
    $(".config_kind_div").css("display","none");
    if(index>1){
      $(".config_kind_div").eq(index-1).css("display","block");
    }
  }

  // configのみ、ボタンに連動してul変更(既存編集)
  function viewChangeWhenLiClick2(index){
    // indexはsecond_liの登場順、連動してconfig_edit_diを開ける
    $(".config_edit_div").css("display","none");
    $(".config_edit_div").eq(index-1).css("display","block");
  }





})