$(()=>{

  const decodedData = atob($("#quiz_hidden").data("all"));
  const inflatedData = pako.inflate(decodedData, { to: 'string' });
  const alldata=JSON.parse(inflatedData);


  // テーマ表示
  if($("#theme_other")){
    theme_display();
  };
                                                   





  $("#play_quiz_btn").click((e)=>{

    e.preventDefault();

    if($("#user_answer").val()===""){
      alert("回答が入力されていません");
      return;
    }

    // 正解不正解の表示とクイズの非表示
    let is_ok=answer_check();
    
    if(is_ok!=="ok" && is_ok!=="out"){
      error_display("何らかのエラーです");
      return;
    }

    display_change("after",is_ok);

    // 正解不正解のデータ登録
    result_plus(is_ok)
    
    // 現在何問目か
    const mondai_num=$("#nanmonme").text()
        
    // クイズの入換
    change_quiz(alldata,mondai_num);

    // クイズの表示と正解不正解の非表示
    $("#to_next_question").click(()=>{
      if(parseInt(mondai_num)===alldata.length){
        end_function();
      }else{
        display_change("before");
      }
    })    
  })



// テーマの表示
function theme_display(){
  $("#theme_other").hover(
    ()=>{
    const y=$("#theme_other").offset().top;
    const x=$("#theme_other").offset().left;
    $("#display_themeother").css({
    "display":"block",
    "top": y + 20 + "px",
    "left": x - 20 + "px",
    "height":parseInt($("#display_themeother").data("count")) * 20 + "px"
   })
  },
  ()=>{
    $("#display_themeother").css("display","none");
  }
 );
}



// 回答チェック
function answer_check(){
  let array=[$("#quiz_hidden").data("answer")]
  for(let n=2;n<6;n++){
    array.push($("#quiz_hidden").data("answer"+n))
  }

  // answer1~5と回答が同じか？
  if(array.includes($("#user_answer").val())){
    return "ok";
  }else{
    return "out";
 }
}


// 正解不正解の表示とformの非表示
function display_change(flug1,flug2=""){
  if(flug1==="after"){
    // 回答後の処理
    $("#play_quiz_corner").css("display","none");
    if(flug2==="ok"){
      $("#display_isok").css("display","block");
      $("#isok_ok").css("display","block");
      $("#isok_out").css("display","none");
      $("#display_isok").css("background-color","yellow");
      $("#display_isok").css("height","75px");
      $("#right_sum").text(parseInt($("#right_sum").text())+1);
    }else if(flug2==="out"){
      $("#display_isok").css("display","block");
      $("#isok_ok").css("display","none");
      $("#isok_out").css("display","block");
      $("#seikai_display").text($("#quiz_hidden").data("answer"));
      $("#display_isok").css("background-color","gray");
      $("#display_isok").css("height","100px");
      $("#wrong_sum").text(parseInt($("#wrong_sum").text())+1);
    }
  }else if(flug1==="before"){
    // 出題側の処理
    $("#user_answer").val("");
    $("#async_error").css("display","none");
    $("#display_isok").css("display","none");
    $("#play_quiz_corner").css("display","block");
  }else{
    error_display("何らかのエラーです");
  }
 }

//  クイズの入替
 function change_quiz(alldata,mondai_num){
    
  if(parseInt(mondai_num)===alldata.length){
    $("#to_next_question").text("最終結果表示");
    return;
  }


    // 問題の入替
    $("#mondai").text(alldata[mondai_num].quiz);

    // 回答などの入替
    $("#quiz_hidden").data("id",alldata[mondai_num].id)
    $("#quiz_hidden").data("answer",alldata[mondai_num].answer)
    $("#quiz_hidden").data("answer2",alldata[mondai_num].answer2)
    $("#quiz_hidden").data("answer3",alldata[mondai_num].answer3)
    $("#quiz_hidden").data("answer4",alldata[mondai_num].answer4)
    $("#quiz_hidden").data("answer5",alldata[mondai_num].answer5)

    // 何問目かの表示入替
    $("#nanmonme").text(parseInt(mondai_num)+1);

    // 回答を空にする
    $("#user_answer").text();
  }
  
  // 結果登録
  function result_plus(is_ok){
    fetch(
      "/quiz/check",
      {
        method:"post",
        headers:{
          // Laravelで必要なCSRFヘッダーを追加
          'X-CSRF-TOKEN': window.csrf_token
      },
        body:new URLSearchParams({
          is_ok:is_ok,
          quiz_id:$("#quiz_hidden").data("id")
        })
      }
    ).then((response)=>{
      if (response.status === 204) {
        // 204 No Contentレスポンスの場合、データが存在しない
        return;
      }else{
        return response.json();
      }
    }).then((json)=>{
      if(typeof json==="object" && Object.keys(json).includes("result_plus")){
        if(json.result_plus==="error"){
          error_display("何らかのエラーにより、履歴に正解/不正解が登録されませんでした");
        }
      }
    });
  }

// 最終結果発表
function end_function(){
  $("#last_correct_span").text($("#right_sum").text());
  $("#last_wrong_span").text($("#wrong_sum").text());
  $("#display_isok").css("display","none");
  $("#quiz_play_conf").css("display","none");
  $("#end_of_quiz").css("display","block");
  if($("#play_results")){
    $("#play_results").css("display","none");
  }
}




  // エラー表示
  function error_display(word){
    $("#play_quiz_error").css("display","block");
    $("#play_quiz_error").children().eq(0).text(word);
  }


// jqueryの終端
})