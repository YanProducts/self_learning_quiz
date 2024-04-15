$(()=>{

  //どのクイズを表示するかのfunction
  function viewQuizTrLists(){
    // trのview
      $(".edit_quiz_what").each((eq,elem)=>{
        if(eq>Number($("#table_view_number").val())*10 && eq<(Number($("#table_view_number").val())+1)*10){
            $(elem).css("display","table-row")
        }else{
            $(elem).css("display","none")
        }
      })
    //   前の10件、次の10件
      if(Number($("#table_view_number").val())===0){
        console.log( $("#ediit_view_10quiz_toBefore"));
        $("#edit_view_10quiz_toBefore").css("display","none");
        $("#edit_view_10quiz_toAfter").css("display","block");
      }else if(Number($("#table_view_number").val())===Math.floor($(".edit_quiz_what").length/10)){
        $("#edit_view_10quiz_toBefore").css("display","block");
        $("#edit_view_10quiz_toAfter").css("display","none");
       }else{
        $("#edit_view_10quiz_toBefore").css("display","block");
        $("#edit_view_10quiz_toAfter").css("display","block");
       }
  }
  //初期
  viewQuizTrLists();
  //ページチェンジ
  $("#edit_view_10quiz_toBefore").click((eq,elem)=>{
    $("#table_view_number").val(Number($("#table_view_number").val())-1);
    viewQuizTrLists();
})
$("#edit_view_10quiz_toAfter").click((eq,elem)=>{
    $("#table_view_number").val(Number($("#table_view_number").val())+1);
    viewQuizTrLists();
})




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
