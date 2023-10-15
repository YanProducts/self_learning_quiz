$(()=>{


  // テーマ設定のli要素をクリックすると、uiの色とoptionの選択が変更、

  // 個別選択の場合
  $(".beforequiz_theme_li").each((eq,elem)=>{
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
  });


  // 全テーマがクリック＝該当する全要素を反転
  $(".beforequiz_theme_li0").each((eq,elem)=>{
    // 全ての全テーマ
    if(eq===0){
      $(elem).click(()=>{
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
      });
    // 種類ごとの全テーマ
    }else{
      $(elem).click(()=>{
        const kind=$(elem).data("kind");
        // その種類の「全テーマ」が選択されていないとき
        if(!$("#theme_select_beforequiz").val().includes("all_themes_" + kind)){
          // その種類の各テーマの挿入
          $(".beforequiz_theme_li[data-kind=" + kind + "]").css("background-color","skyblue");
          $(".beforequiz_theme_hidden[data-kind=" + kind + "]").prop("selected",true);
          $(".beforequiz_theme_hidden0[data-kind=" + kind + "]").prop("selected",true);
        // 現時点で選択されていないとき
        }else{
          // その種類の各テーマの消去
          $(".beforequiz_theme_li[data-kind=" + kind + "]").css("background-color","white");
          $(".beforequiz_theme_hidden[data-kind=" + kind + "]").prop("selected",false);
          $(".beforequiz_theme_hidden0[data-kind=" + kind + "]").prop("selected",false);
        }
        $("#now_choice_themes").text(show_theme_names());
      })
    }
  })

  

// 現在取得中のテーマを文字列で返す
function show_theme_names(){
  if($("#theme_select_beforequiz").val().length>0){
    if($("#theme_select_beforequiz").val().includes("all_themes")){
      return "全種類";
    // }else if($("#theme_select_beforequiz").val().filter(function(fff){ return fff.includes("all_themes");})){
    //   return "の全種類";
    }
    else
    {
      return $("#theme_select_beforequiz").val().join("、");
    }
 }else{
  return "選択なし"
 }
}



  // jqueryの終端
})