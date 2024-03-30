// トップページなどに使用
// liでoption連動

$(()=>{

  // liをクリックするとoptionが動く

  const li_sets=[".first_li",".second_li",".third_li",".fourth_li"];
  const option_sets=[".first_option",".second_option",".third_option",".fourth_option"];

  for(let n=0;n<li_sets.length;n++){
    if($(li_sets[n]).length>0){
      $(li_sets[n]).each(function(index,elem){
        $(elem).click(function(){
          $(li_sets[n]).removeClass("first_li_click")
          $(option_sets[n]).eq(index).prop("selected",true);
          $(this).addClass("first_li_click");


          // configページ、それぞれliをクリック時に開く要素
          if($("#config_create_form").length>0){
            if(li_sets[n]===".first_li"){
            viewChangeWhenLiClick1(index);
            }else if(li_sets[n]===".second_li"){
            viewChangeWhenLiClick2(index);
            }else if(li_sets[n]===".third_li"){
            viewChangeWhenLiClick3(index);
          }else if(li_sets[n]===".fourth_li"){
            viewChangeWhenLiClick4(index);
            }
          }

          // テーマ削除の際にクイズをどうするか確認ページ
          if($("#config_quizWhenDeleteTheme_form").length>0){
            if(li_sets[n]===".first_li"){
              viewChangeWhenLiClick5(index);
            }
          }

        });
      });
    }
  }


// 何も選択されていない時は返す
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
    // 大テーマが存在しないときは大テーマの編集はできない
    if($("#ifKindDoesNotExists").length>0 && index===2){
        alert("大テーマが１つもありません");
        return;
    }

    // indexはsecond_liの登場順、連動してconfig_edit_diを開ける
    $(".config_edit_div").css("display","none");
    $(".config_edit_div").eq(index-1).css("display","block");
  }


  // configのみ、小テーマの大テーマへの移動
  function viewChangeWhenLiClick3(index){
    // 大テーマが1つもないと既存の大テーマには移動できない
    if($("#ifKindDoesNotExists").length>0 && index===2){
        alert("大テーマが１つもありません");
        return;
    };
    $(".config_move_div").css("display","none");
    $(".config_move_div").eq(index-1).css("display","block");
  }

  // configのみ、テーマの消去
  function viewChangeWhenLiClick4(index){
    // 大テーマが1つもないと既存の大テーマには移動できない
    if($("#ifKindDoesNotExists").length>0 && index===2){
        alert("大テーマが１つもありません");
        return;
    };
    $(".config_delete_div").css("display","none");
    $(".config_delete_div").eq(index-1).css("display","block");
  }

  // configのみ、テーマ削除の際にクイズをどうするか確認ページ...新しいテーマ挿入inputのdivを開く
  function viewChangeWhenLiClick5(index){
    if(index===1){
      $("#config_newTheme_whenDelete").css("display","block");
    }else{
      $("#config_newTheme_whenDelete").css("display","none");
    }

    if(index===2){
      $("#config_existTheme_whenDelete").css("display","block");
    }else{
      $("#config_existTheme_whenDelete").css("display","none");

    }

  }




})
