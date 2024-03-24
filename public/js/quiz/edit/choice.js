$(()=>{
  // テーブルの各要素をクリックした時の操作
  $(".edit_quiz_what").each((eq,elem)=>{
    $(elem).hover(()=>{
    // マウスホバー
      if($(elem).css("background-color")==="rgba(0, 0, 0, 0)"){
        $(elem).css("background-color","rgb(250, 240, 230)");
      }
    },
    // マウスホバー外れた時
      ()=>{
        if($(elem).css("background-color")!=="rgb(230, 220, 110)"){
          $(elem).css("background-color","rgba(0, 0, 0, 0)");
        }
      }
    )

    $(elem).click(()=>{
      // trのdata属性にクイズidをセット
      $("#hidden_edit_quiz_decide").val($(elem).data("id"));
      
      // 色の固定（それ以外の色をなくす）
      $(".edit_quiz_what").css("background-color","rgba(0, 0, 0, 0)");
      $(elem).css("background-color","rgb(230, 220, 110)");
    })
 })
})