// 作成ページ

$(()=>{
  // テーマ選択でhiddenのselectが動く
  $(".quiz_create_each_theme").each((index,elem)=>{
    $(elem).click(()=>{
      if(!$(".quiz_create_hidden_option").eq(index).prop("selected")){
        $(elem).css("background-color","skyblue");
        $(".quiz_create_hidden_option").eq(index).prop("selected",true);
      }else{
        $(elem).css("background-color","white");
        $(".quiz_create_hidden_option").eq(index).prop("selected",false);
      }
     })
  })

    //  編集の場合＝削除のリンクを押せば削除のform投稿
    if($("#ifQuizDeleteForm").length>0){
        $("#ifQuizDeletePatternSpan").click(function(){
            if(!confirm("このクイズを削除しますか？")){
                return;
            }
            $("#ifQuizDeleteForm").submit();
        })
    }


        // 2重投稿防止
        $("#quiz_create_form").submit(function(){
            if($("#quiz_create_form").data("isSubmit")!=="already"){
                // 送信済のサイン入れる
                $("#quiz_create_form").data("isSubmit","already")
                //   ボタン無効化
                $("button").prop("disabled",true);
                return true;
            }else{
                  e.preventDefault();
                  alert("投稿時にエラーが生じたので\n処理を中断しました");
                  $("#quiz_create_form").data("isSubmit","yet")
                  location.reload()
                  return false;
              }
        });

})
