$(()=>{

  // どのパターンで編集クイズを選択するかのボタン
  $("#before_edit_to_next").click(()=>{
    // 選択領域を非表示に
    $("#quiz_edit_ptn_div").css("display","none");

    switch($("#type_select").val()){
      // 全クイズから検索
      case "from_all":
        $("#before_edit_from_all").submit();
      break;
      // 言葉の１部から検索
      case "from_words":
        $("#before_edit_from_words").css("display","block");
      break;
      // 条件から検索
      case "from_case":
        $("#before_edit_from_case").css("display","block");
      break;
      default:
        alert("不正な処理です");
        $("#quiz_edit_ptn_div").css("display","block");
      break;
    }
  })

  
  // and条件クリック
  $("#and_addition").click(()=>{
    if(!before_addition()){
      return;
    }
    word_add_click("type_a","AND");
  })

  // or条件クリック
  $("#or_addition").click(()=>{
    // 両方が入力されている時に限り作動
    if(!before_addition()){
      return;
    }
    word_add_click("type_o","OR");
  })

  // 追加条件クリック
  $("#normal_addition").click(()=>{
    if(!before_addition()){
      return;
    }
    word_add_click("","");
  });

  // 削除ボタンが押された時
  $(".edit_words_delete_btn").click((e)=>{
    // 何個目かを減らす
    $("#edit_what_num").val(parseInt($("#edit_what_num").val()) - 1 );
    // 削除
    const delete_div=$(e.target).closest("div");
    $(delete_div).remove();
    // 残りが１つならcssをnoneに
    if($(".edit_words_delete_btn").length===1){
      edit_word_default();
    }
  })

  // 初期化ボタンが押された時
  $("#edit_back_search").click(()=>{
    edit_word_default();
  })

  // エラーがあった時
  if($(".if_error1").length > 0){
    $(".if_error1").closest("form").css("display","block");
    $("#quiz_edit_ptn_div").css("display","none");
  }

// and検索/or検索の前段階の追加
function before_addition(){
  // 全てのinputとselectの両方が入力されている時に限り作動
  for(let setnum=0;setnum<$(".edit_words_sentence").length;setnum++){
    if($(".edit_words_sentence").eq(setnum).children("input").val()==="" || $(".edit_words_sentence").eq(setnum).children("select").val()==="no_choise"){
     alert("未入力の項目があります");
     return false;
   }
  }
  return true;
}


  // 言葉検索条件追加の共通処理
  function word_add_click(type_ptn,type_word){
    if(type_ptn!==""){
      // 初期の場合、andor条件を変数とUIに入れてandor条件を消して削除を表示
      $("#edit_search_andor").val(type_ptn);
      $("#edit_andor_display_span").text(type_word+"条件で検索中");
      $(".edit_words_delete_btn").css("display","inline");
      $("#edit_word_condition_space").css("display","none");
      $("#edit_back_search").css("display","block");
      $("#now_edit_andor").css("display","block");
    }

    // 条件追加要素作成
    const ddd=$(".edit_words_sentence").eq(0).clone(true);
    $(ddd).children("option").eq(0).prop("selected",true);
    $(ddd).children("input").val("");
    $("#edit_words_phrase").append($(ddd));

    // 何個目の条件か追加
    $("#edit_what_num").val(parseInt($("#edit_what_num").val()) + 1 );

    // selectとinputのnameを振り直す
    const selects=$("#edit_words_phrase").find("select");
    const input=$("#edit_words_phrase").find("input");

    for(let select_num=0;select_num<selects.length;select_num++){
      $(selects).eq(select_num).prop("name","search_where" + select_num);
      $(input).eq(select_num).prop("name","search_words" + select_num);
    }

  }

  // 言語検索条件の初期化
  function edit_word_default(){
    // ２つ目の削除ボタン以降の削除
    if($(".edit_words_sentence").length > 1){
      for(let n=$(".edit_words_sentence").length;n>0;n--){
        $(".edit_words_sentence").eq(n).remove()
      }
    }
    // 表示の初期化
    $("#edit_what_num").val(0);
    $(".edit_words_delete_btn").css("display","none");
    $("#edit_word_condition_space").css("display","flex");
    $("#edit_back_search").css("display","none");
    $("#now_edit_andor").css("display","none");
  }

})