// 設定ページ

$(()=>{
  // liをクリックすればformが変動
  $(".theme_li").each(function(index,elem){
    $(elem).click(function(){

    // 小テーマが１つもない場合
    // ２〜４つ目は不可能
    if($("#ifThemeDoesNotExists").length>0 && index!==0){
        alert("まずは小テーマを設定してください");
        return;
    }

      $(".theme_li").removeClass("theme_li_click")
      $(".config_form").css("display","none");
      $(".config_form").eq(index).css("display","block");
      $(this).addClass("theme_li_click");
    });
  });

  // moveの現在大テーマ
  if($("#move_before_theme_select").length>0){
    $("#move_before_theme_select").change((e)=>{
      // 選択テーマの大テーマのデフォルト。再利用するため別定義
        let choicedBigThemeName="";

      // まず全ての表示を消す
      $(".now_choice_move_theme_default").css("display","none");
      $(".now_choice_move_theme").css("display","none");

      // 該当の大テーマのみ表示
      $(".now_choice_move_theme").each((index,elem)=>{
        if($(elem).data("id")===parseInt(e.currentTarget.value)){
          $(elem).css("display","block");
          choicedBigThemeName=$(elem).data("contents");
      }
    

     // 現在の大テーマを移動先の大テーマのoptionから削除
        // ひとまず全部開ける
        $(".move_after_kind_option").css("display","inline");
        // 該当のものは非表示
        $(".move_after_kind_option").each((index,elem)=>{
            if($(elem).val()===choicedBigThemeName){
                $(elem).css("display","none");
            }
        });


     });
    })
  }

  // deleteで小テーマを削除する時に既存のクイズを新しいテーマに設定する時
  // クリックすれば既存クイズのテーブル表示
  if($("#quizSample_whenDeleteTheme_div").length>0){

    $("#show_quiz_table_span").click(function(){
      $("#show_quiz_table_p").css("display","none");
      $("#hide_quiz_table_p").css("display","block");
      $("#tableSample_whenDeleteTheme").css("display","block");
    })

    $("#hide_quiz_table_p").click(function(){
      $("#show_quiz_table_p").css("display","block");
      $("#hide_quiz_table_p").css("display","none");
      $("#tableSample_whenDeleteTheme").css("display","none");
    })

  }


})
