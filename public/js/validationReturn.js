"use strict"

// バリデーションで返ってきた要素を開くJs
$(()=>{
  //config-新しいテーマの名前
  if($("#validationReturn_newThemeName").length>0){
    $(".config_form").eq(0).css("display","block");
    $(".theme_li").eq(0).addClass("theme_li_click");
    $("#validationReturn_newThemeName").closest(".config_label_div").css("display","block");
    $(".first_option").eq(1).prop("selected",true);
    $(".first_li").eq(1).addClass("first_li_click");
    setTimeout(()=>{
      $("#validationReturn_newThemeName").next(".if_error0").css("display","none");
    },3000);
  }

  //config-種類既存
  if($("#validationReturn_existKindSelect").length>0){
    $(".config_form").eq(0).css("display","block");
    $(".theme_li").eq(0).addClass("theme_li_click");
    $("#validationReturn_existKindSelect").closest(".config_label_div").css("display","block");
    $(".first_option").eq(2).prop("selected",true);
    $(".first_li").eq(2).addClass("first_li_click");

    setTimeout(()=>{
      $("#validationReturn_existKindSelect").next(".if_error0").css("display","none");
    },3000);
  }


  //config-種類新規
  if($("#validationReturn_newKindName").length>0){
    $(".config_form").eq(0).css("display","block");
    $(".theme_li").eq(0).addClass("theme_li_click");
    $("#validationReturn_newKindName").closest(".config_label_div").css("display","block");
    $(".first_option").eq(3).prop("selected",true);
    $(".first_li").eq(3).addClass("first_li_click");
    setTimeout(()=>{
      $("#validationReturn_newKindName").next(".if_error0").css("display","none");
    },3000);
  }


  //config-テーマの編集
  if($("#validationReturn_editThemeName").length>0){
     $(".config_form").eq(1).css("display","block");
    $(".theme_li").eq(1).addClass("theme_li_click");
    $("#validationReturn_editThemeName").closest(".config_label_div").css("display","block");
    $(".second_option").eq(1).prop("selected",true);
    $(".second_li").eq(1).addClass("first_li_click");
    setTimeout(()=>{
      $("#validationReturn_editThemeName").next(".if_error0").css("display","none");
    },3000);
  }


  //config-種類の編集
  if($("#validationReturn_editKindName").length>0){   
     $(".config_form").eq(1).css("display","block");
    $(".theme_li").eq(1).addClass("theme_li_click");
    $("#validationReturn_editKindName").closest(".config_label_div").css("display","block");
    $(".second_option").eq(2).prop("selected",true);
    $(".second_li").eq(2).addClass("first_li_click");
    setTimeout(()=>{
      $("#validationReturn_editKindName").next(".if_error0").css("display","none");
    },3000);
  }

})

