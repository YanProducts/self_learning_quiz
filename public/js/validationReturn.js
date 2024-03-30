"use strict"

// バリデーションで返ってきた要素を開くJs
$(()=>{

  //削除テーマがテーマがそれのみのクイズに含まれている時
  if($("#config_quizWhenDeleteTheme_form").length>0){
    validationOpen("#validationReturn_newInputWhenDelete","","","#config_newTheme_whenDelete","first",1);
    validationOpen("#validationReturn_existSelectWhenDelete","","","#config_existTheme_whenDelete","first",2);

    // それ以外
  }else{

    // config_create
    //新しいテーマの名前
    validationOpen("#validationReturn_newThemeName",0,0,"","","");
    //大テーマ既存
    validationOpen("#validationReturn_existKindSelect",0,0,".config_label_div","first",2);
    //大テーマ新規
    validationOpen("#validationReturn_newKindName",0,0,".config_label_div","first",3);


    // config_edit
    // phpで取得している$keyの最初が小文字なのに注意
    //テーマの編集
    validationOpen("#validationReturn_edit_themeName",1,1,".config_edit_div","second",1);
    //大テーマの編集
    validationOpen("#validationReturn_edit_kindName",1,1,".config_edit_div","second",2);
    //テーマの編集の既存取得
    validationOpen("#validationReturn_old_themeId",1,1,".config_edit_div","second",1);
    //大テーマの編集の既存取得
    validationOpen("#validationReturn_old_kindId",1,1,".config_edit_div","second",2);


    // config_move

    // 移動する小テーマ
    validationOpen("#validationReturn_move_beforeThemeId",2,2,"","","");
    // 新しい大テーマへ
    validationOpen("#validationReturn_move_newKind",2,2,".config_move_div","third",0);
    // 以前の大テーマへ
    validationOpen("#validationReturn_move_beforeKind",2,2,".config_move_div","third",1);


    // config/delete
    // 小テーマ消去
    validationOpen("#validationReturn_delete_themeId",3,3,".config_delete_div","fourth",0);

    // 大テーマ消去
    validationOpen("#validationReturn_delete_kind",3,3,".config_delete_div","fourth",1);

  }




  // 開けるfunction
  function validationOpen(openElement,configIndex,themeIndex,openDiv,liOptionNum,optionIndex){

    // エラーが存在したら
      if($(openElement).length>0){

        // エラー上位の上位のformを開ける
        if(configIndex!==""){
          $(".config_form").eq(configIndex).css("display","block");
          // configのトップページのformのliをクリック状態に
          $(".theme_li").eq(themeIndex).addClass("theme_li_click");
        }

        // 必要ならエラー対象のdiv要素を開ける
        if($(openDiv).length>0){
          $(openElement).closest(openDiv).css("display","block");
        }


        // 新しいテーマ作成の場合、大テーマ設定ありでもなしでも「テーマ入力」が必要。その場合、テーマをどうするかは無関係。

        // 汎用的に直す！！
        // if(openElement!=="#validationReturn_newThemeName"){




        // liオプションをクリック状態に
        console.log(optionIndex);
        console.log($("." + liOptionNum + "_option").eq(optionIndex))
          $("." + liOptionNum + "_option").eq(optionIndex).prop("selected",true);
          $("." + liOptionNum + "_li").eq(optionIndex).addClass("first_li_click");

          $(".first_option").eq(optionIndex).prop("selected",true);
          $(".first_li").eq(optionIndex).addClass("first_li_click");

        setTimeout(()=>{
          $(openElement).next(".if_error0").css("display","none");
        },3000);
      }
    }

})

