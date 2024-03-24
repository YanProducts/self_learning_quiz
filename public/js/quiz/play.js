$(()=>{

  // クイズが０問のときは終了
  if( $("#quiz_hidden").data("all")===null || typeof($("#quiz_hidden").data("all"))==="undefined"){
    return;
  }

  // 圧縮したjsonデータの解凍
  const decodedData = atob($("#quiz_hidden").data("all"));
  const inflatedData = pako.inflate(decodedData, { to: 'string' });
  const alldata=JSON.parse(inflatedData);


  // テーマ表示
  if($("#theme_other")){
    theme_display();
  };

  //  クイズのパターン(回答の有無)
  const ptn=Number($("#quiz_hidden").data("ptn"));

  //  回答必須なら回答欄フォーカス
  if(ptn===0){
    $("#user_answer").focus();
  }

  // 回答ボタンが押されたとき（どちらのptnでもこの処理へ)
  $("#play_quiz_btn").click((e)=>{

    e.preventDefault();

    // 回答があるかどうか
    if(ptn===0){
      if($("#user_answer").val()===""){
        alert("回答が入力されていません");
        return;
      }
      // 正解不正解チェック
      let is_ok=answer_check();

      // 正解不正解が正しい値か
      // returnのタイミングうまくいっているか確認しよう！！！！！！（結果挿入されていないか？）
      if(is_ok!=="ok" && is_ok!=="out"){
        error_display("何らかのエラーです");
        return;
      }

      // 画面変更
      display_change("after",is_ok);

      // 結果の挿入
      result_plus(is_ok)

    }else{
      // 画面変更（回答は文章の時）
      display_change("after","without");
    }


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
      $("#right_sum").text(parseInt($("#right_sum").text())+1)
    }else if(flug2==="out"){
      $("#display_isok").css("display","block");
      $("#isok_ok").css("display","none");
      $("#isok_out").css("display","block");
      $("#seikai_display").text($("#quiz_hidden").data("answer"));
      $("#display_isok").css("background-color","gray");
      $("#display_isok").css("height","100px");
      $("#wrong_sum").text(parseInt($("#wrong_sum").text())+1);
    }else if(flug2==="without"){
      // 解説の表示
      $("#display_without").css("display","block");
      $("#seikai_display").text($("#quiz_hidden").data("answer"));
      $("#display_without").css("background-color","skyblue");
      $("#display_without").css("height","100px");
    }
  }else if(flug1==="before"){
    // 出題側の処理
    $("#user_answer").val("");
    $("#async_error").css("display","none");
    if($("#display_isok")){
      $("#display_isok").css("display","none");
    }
    if($("#display_without")){
      $("#display_without").css("display","none");
    }
    $("#play_quiz_corner").css("display","block");
    // 回答欄にフォーカス
    if(flug2!=="without"){
        $("#user_answer").focus();
    }
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


    // データの入替
    $("#quiz_hidden").data("id",alldata[mondai_num].id)
    $("#quiz_hidden").data("theme",alldata[mondai_num].theme_name)
    $("#quiz_hidden").data("theme2",alldata[mondai_num].theme_name2)
    $("#quiz_hidden").data("theme3",alldata[mondai_num].theme_name3)
    $("#quiz_hidden").data("level",alldata[mondai_num].level)
    $("#quiz_hidden").data("correct",alldata[mondai_num].correct)
    $("#quiz_hidden").data("wrong",alldata[mondai_num].wrong)
    $("#quiz_hidden").data("answer",alldata[mondai_num].answer)
    $("#quiz_hidden").data("answer2",alldata[mondai_num].answer2)
    $("#quiz_hidden").data("answer3",alldata[mondai_num].answer3)
    $("#quiz_hidden").data("answer4",alldata[mondai_num].answer4)
    $("#quiz_hidden").data("answer5",alldata[mondai_num].answer5)


    // 表示の入替
    $("#mondai").text(alldata[mondai_num].quiz);

    // 表示テーマ
    let theme_value=$("#quiz_hidden").data("theme");
    if($("#quiz_hidden").data("theme2")){
      theme_value=theme_value + " " + $("#quiz_hidden").data("theme2");
      if($("#quiz_hidden").data("theme3")){
        theme_value=theme_value + " " +$("#quiz_hidden").data("theme3");
      }
    }
    $("#each_quiz_theme_span").text(theme_value);

    // 表示パーセント
    let percent="";
    if($("#quiz_hidden").data("correct")+$("#quiz_hidden").data("wrong")===0){
      percent="0%";
    }else{
      percent=Math.round($("#quiz_hidden").data("correct")/($("#quiz_hidden").data("correct")+$("#quiz_hidden").data("wrong"))*100,1) + "%";
    }

    $("#each_quiz_percent_span").text(percent);

    $("#each_quiz_level_span").text($("#quiz_hidden").data("level"));

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
          'X-CSRF-TOKEN': window.csrf_token,
          "Accept": "application/json"
        },
        body:new URLSearchParams({
          is_ok:is_ok,
          quiz_id:$("#quiz_hidden").data("id")
        })
      }
    ).then((response)=>{
      if(!response.ok){
        return response.json().then((err)=>{
          return Promise.reject(err);
        });
      }
      //  成功の場合は何もしない
    }).catch((err)=>{
      error_display("何らかのエラーにより、履歴に正解/不正解が登録されませんでした");
    })
  }

// 最終結果発表
function end_function(){
  $("#last_correct_span").text($("#right_sum").text());
  $("#last_wrong_span").text($("#wrong_sum").text());
  $("#display_isok").css("display","none");
  $("#quiz_play_conf").css("display","none");
  $("#play_quiz_corner").css("display","none");
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
