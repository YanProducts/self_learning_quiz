{{-- 言葉の１部から検索する場合 --}}
{{-- 次で該当クイズリストを表示する --}}
<form id="before_edit_from_words" method="post" action={{route("edit_from_words_route")}}>
  @csrf

  {{-- 各検索 --}}
  <div id="edit_words_phrase">
    <div class="edit_words_sentence">
    <select class="before_edit_words_select" name="search_where0">
      <option hidden class="words_from_where" value="no_choise">選択してください</option>
      <option class="words_from_where" value="title">タイトル</option>
      <option class="words_from_where" value="quiz">本文</option>
      <option class="words_from_where" value="answer">解答</option>
      <option class="words_from_where" value="all">上記のどこか</option>
    </select>
    に
    <input type="text" name="search_words0">
    を含む
    {{-- 初期は非表示 --}}
    <span class="edit_words_delete_btn">✖️</span>
  </div>
   @foreach($errors->getMessages() as $key=>$messages)
    @if(str_contains($key,"search_where"))
      @foreach($messages as $message)
      <p class="if_error0">{{$message}}</p>
      @endforeach
    @endif
    @if(str_contains($key,"search_words"))
      @foreach($messages as $message)
      <p class="if_error0">{{$message}}</p>
      @endforeach
    @endif
  @endforeach
  </div>


  
  {{-- andかorか、追加する際の表示 --}}
  <div id="edit_andor_display">
    {{-- 初期は表示 --}}
    <div id="edit_word_condition_space">
      <span id="and_addition">AND条件追加</span>
      <span id="or_addition">OR条件追加</span>
    </div>
    {{-- 何個目の条件か --}}
      <input type="hidden" id="edit_what_num" name="what_num" value=0>
      <input type="hidden" id="edit_search_andor" name="edit_search_andor" value="normal">
      {{-- 初期は非表示 --}}
      <p id="now_edit_andor"><span id="edit_andor_display_span"></span>
        <span id="normal_addition">追加！</span></p>
      <p id="edit_back_search">初期化</p>
  </div>
    
  @error("what_num")
    <p class="if_error0">{{$message}}</p>
  @enderror
  @error("edit_search_andor")
    <p class="if_error0">{{$message}}</p>
  @enderror

  <div class="btn_div">
    <button id="edit_word_btn2">検索！</button>
  </div> 

</form>



