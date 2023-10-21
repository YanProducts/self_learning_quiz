$(()=>{


  // テーマ設定のli要素をクリックすると、uiの色とoptionの選択が変更、

  // 個別選択の場合
  $(".beforequiz_theme_li").each((eq,elem)=>{
     each_theme_change(eq,elem)
  });

  // 全テーマがクリック＝該当する全要素を反転
  $(".beforequiz_theme_li0").each((eq,elem)=>{
    // 全ての全テーマ
    if(eq===0){
      $(elem).click(()=>{
        all_themes_change1();
      });
    // 種類ごとの全テーマ
    }else{
      $(elem).click(()=>{
        all_themes_change2(elem)
      })
    }
  })

  // 回答形式が変更＝正解率の表示変更
  $("#answer_select_beforequiz").change(()=>{
    percent_display_change();
  })

  // 最小％が変更したとき
  $("#percent_select_beforequiz1").change(()=>{
    auto_max_change("percent")
  })
  
  // 最小レベルが変更したとき
  $("#level_select_beforequiz1").change(()=>{
    auto_max_change("level")
  })
  

// 個別項目の変化時
function each_theme_change(eq,elem){
  $(elem).click(()=>{

    // 全種類全選択はいずれにせよ外す（結果的にそうなっている場合は全テーマを個別と言う形式で選択）
    $(".beforequiz_theme_hidden0").eq(0).prop("selected",false);

    // その種類の全種類の消去
    const kind=$(elem).data("kind");
    $(".beforequiz_theme_hidden0[data-kind=" + kind + "]").prop("selected",false);

    // 選択→非選択
    if($(".beforequiz_theme_hidden").eq(eq).prop("selected")===true){
      $(elem).css("background-color","white");
      $(".beforequiz_theme_hidden").eq(eq).prop("selected",false);
    // 非選択→選択
    }else{ 
      $(".beforequiz_theme_hidden").eq(eq).prop("selected",true);
      $(elem).css("background-color","skyblue");
    }
    $("#now_choice_themes").text(show_theme_names());
  })
}

// 全体項目の変化時(全種類)
function all_themes_change1(){
  if(!$("#theme_select_beforequiz").val().includes("all_themes")){
    // 各テーマごとの全種類も完全消去
    $(".beforequiz_theme_hidden0").prop("selected",false);
    $(".beforequiz_theme_hidden").prop("selected",true);
    $(".beforequiz_theme_li").css("background-color","skyblue");        
    $(".beforequiz_theme_hidden0").eq(0).prop("selected",true);
  }else{
    $(".beforequiz_theme_hidden").prop("selected",false);
    $(".beforequiz_theme_li").css("background-color","white"); 
    // 各テーマごとの全種類も完全消去
    // ifの条件分岐に影響を与えるため、if~else両方で同じ式を書く必要あり
    $(".beforequiz_theme_hidden0").prop("selected",false);
  }
  $("#now_choice_themes").text(show_theme_names());
}

// 全体項目の変化時(個別)
function all_themes_change2(elem){
   // いずれにせよ全テーマ全種類は削除
   $(".beforequiz_theme_hidden0").eq(0).prop("selected",false);
   $(".beforequiz_theme_hidden0").eq(0).css("background-color","white");

   const kind=$(elem).data("kind");
   // その種類の「全テーマ」が選択されていないとき
   if(!$("#theme_select_beforequiz").val().includes("all_themes_" + kind)){
     // その種類の各テーマの挿入
     $(".beforequiz_theme_li[data-kind=" + kind + "]").css("background-color","skyblue");
     $(".beforequiz_theme_hidden[data-kind=" + kind + "]").prop("selected",true);
     // その種類の全テーマの挿入
     $(".beforequiz_theme_hidden0[data-kind=" + kind + "]").prop("selected",true);
   // 現時点で選択されているとき＝これから消去されるとき
   }else{
     // その種類の各テーマの消去
     $(".beforequiz_theme_li[data-kind=" + kind + "]").css("background-color","white");
     $(".beforequiz_theme_hidden[data-kind=" + kind + "]").prop("selected",false);
     // その種類の全テーマの削除
     $(".beforequiz_theme_hidden0[data-kind=" + kind + "]").prop("selected",false);
   }
   $("#now_choice_themes").text(show_theme_names());
}

// 現在取得中のテーマを文字列で返す
function show_theme_names(){
  if($("#theme_select_beforequiz").val().length>0){
    if($("#theme_select_beforequiz").val().includes("all_themes")){
      return "全テーマ全種類";
    }else{
      // テーマの名前表示用（全種類全テーマ以外）
     return choise_theme_name($("#theme_select_beforequiz").val())
    }
 }else{
  return "選択なし"
 }
}

// テーマの名前表示用（全種類全テーマ以外）
function choise_theme_name(selects){
  let newSelects=[];
  selects.forEach((sss)=>{
    if(sss.includes("all_themes")){
      newSelects.push("(" + sss.substring(11) + "の全種類)");
    }else{
      newSelects.push(sss);
    }
  })
  return newSelects.join("、")
}

// 回答形式の変更で正解率の表示変更
function percent_display_change(){
  if(parseInt($("#answer_select_beforequiz").val())===1){
    $("#quiz_before_percents").css("display","none");
  }else if(parseInt($("#answer_select_beforequiz").val())===0){
    $("#quiz_before_percents").css("display","block");
  }
}

// 最小値変化＝最大値変化
function auto_max_change(elem){
  const min_value=parseInt($("#" + elem + "_select_beforequiz1").val());
  const options=$("#" + elem + "_select_beforequiz2").children();


  // 最小値以下の最大値が設定＝最大値は最小値にする
  if(parseInt($("#" + elem + "_select_beforequiz2").val()) < min_value){
    // レベル=要素の番号は数字より１つ下
    if(elem==="level"){
      options.eq(min_value-1).prop("selected",true);
      // %=要素の番号は数字と同じ
    }else if(elem==="percent"){
      options.eq(min_value).prop("selected",true);
    }
  }

  // 最小値未満の最大値を消す
  options.each((eq,option)=>{
    if($(option).val()<min_value){
      $(option).css("display","none");
    }else{
      $(option).css("display","block");
    }
  });

}



  // jqueryの終端
})