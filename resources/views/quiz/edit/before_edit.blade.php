<x-layout>
<x-slot name="title">クイズの編集</x-slot>
<x-slot name="js_sets">{{json_encode($js_sets)}}</x-slot>

@if($errors->any())
{{$error}}
@endif




<h2>編集するクイズはどう選びますか？</h2>

{{-- どの選び方をするか --}}
<div id="quiz_edit_ptn_div">
  @include("common/index_before_edit")
  <div class="btn_div">
    <button  id="before_edit_to_next">これで選ぶ！</button>
  </div>
</div>

{{-- 全クイズから検索＝検索表示 --}}
{{-- データ送信がないのでtokenもいらずget処理 --}}
<form id="before_edit_from_all"  method="get" action={{route("edit_from_all_route")}}>


</form>


{{-- 言葉の１部から検索する場合 --}}
{{-- 次で該当クイズリストを表示する --}}
<form id="before_edit_from_words" method="post" action={{route("edit_from_words_route")}}>
  @csrf

  {{-- 各検索 --}}
  <div id="edit_words_phrase">
    <div class="edit_words_sentence">
    <select class="before_edit_words_select" name="search_where0">
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

  </div>
  
  {{-- andかorか、追加する際の表示 --}}
  <div id="edit_andor_display">
    {{-- 初期は表示 --}}
    <div id="edit_word_condition_space">
      <span id="and_addition">AND条件追加</span>
      <span id="or_addition">OR条件追加</span>
    </div>
    {{-- 何個目の条件か --}}
      <input type="hidden" id="edit_what_num" name="what_num" value="0">
      <input type="hidden" id="edit_search_andor" name="edit_search_andor" value="normal">
      {{-- 初期は非表示 --}}
      <p id="now_edit_andor"><span id="edit_andor_display_span"></span>
        <span id="normal_addition">追加！</span></p>
      <p id="edit_back_search">初期化</p>
  </div>
    
  <div class="btn_div">
    <button id="edit_word_btn2">検索！</button>
  </div> 

</form>

@error("what_num")
  <p class="if_error1">{{$message}}</p>
@enderror
@error("edit_search_andor")
  <p class="if_error1">{{$message}}</p>
@enderror

@foreach($errors->getMessages() as $key=>$message)
  @if(str_contains($key,"search_where"))
   <p class="if_error1">{{$message}}</p>
  @endif
  @if(str_contains($key,"search_words"))
   <p class="if_error1">{{$message}}</p>
  @endif
@endforeach



{{-- 条件から検索する場合--}}
{{-- 次で該当クイズリストを表示する --}}
<form id="before_edit_from_case" method="post" action="{{route("edit_from_case_route")}}">
  @csrf
  @include("common/before_play_edit")
  <div class="btn_div">
    <button id="edit_case_btn">上記で検索！</button>
  </div>
</form>

@include("footer");

</x-layout>