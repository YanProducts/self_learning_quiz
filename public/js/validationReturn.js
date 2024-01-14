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

  //config大テーマ既存
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


  //config-大テーマ新規
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



  // phpで取得している$keyの最初が小文字なのに注意
  //config-テーマの編集
  if($("#validationReturn_edit_themeName").length>0){
    console.log("a");
     $(".config_form").eq(1).css("display","block");
    $(".theme_li").eq(1).addClass("theme_li_click");
    $("#validationReturn_edit_themeName").closest(".config_edit_div").css("display","block");
    $(".second_option").eq(1).prop("selected",true);
    $(".second_li").eq(1).addClass("first_li_click");
    setTimeout(()=>{
      $("#validationReturn_edit_themeName").next(".if_error0").css("display","none");
    },3000);
  }


  //config-大テーマの編集
  if($("#validationReturn_edit_kindName").length>0){
     $(".config_form").eq(1).css("display","block");
    $(".theme_li").eq(1).addClass("theme_li_click");
    $("#validationReturn_edit_kindName").closest(".config_edit_div").css("display","block");
    $(".second_option").eq(2).prop("selected",true);
    $(".second_li").eq(2).addClass("first_li_click");
    setTimeout(()=>{
      $("#validationReturn_edit_kindName").next(".if_error0").css("display","none");
    },3000);
  }

    //config-テーマの編集の既存取得
    if($("#validationReturn_old_themeId").length>0){
      console.log("a");
       $(".config_form").eq(1).css("display","block");
      $(".theme_li").eq(1).addClass("theme_li_click");
      $("#validationReturn_old_themeId").closest(".config_edit_div").css("display","block");
      $(".second_option").eq(1).prop("selected",true);
      $(".second_li").eq(1).addClass("first_li_click");
      setTimeout(()=>{
        $("#validationReturn_old_themeId").next(".if_error0").css("display","none");
      },3000);
    }

    //config-大テーマの編集の既存取得
    if($("#validationReturn_old_kindId").length>0){
      console.log("a");
       $(".config_form").eq(1).css("display","block");
      $(".theme_li").eq(1).addClass("theme_li_click");
      $("#validationReturn_old_kindId").closest(".config_edit_div").css("display","block");
      $(".second_option").eq(1).prop("selected",true);
      $(".second_li").eq(1).addClass("first_li_click");
      setTimeout(()=>{
        $("#validationReturn_old_kindId").next(".if_error0").css("display","none");
      },3000);
    }




    // まとめ






})

