<x-layout>
<x-slot name="title">クイズの編集/削除</x-slot>
<x-slot name="js_sets">{{json_encode($js_sets)}}</x-slot>


<h2 class="h2WithBr500">編集または削除するクイズは<br class="br500">どう選びますか？</h2>

{{-- どの選び方をするか --}}
<div id="quiz_edit_ptn_div">
  @include("common/li_option_view" ,["num"=>"first"])
  <div class="btn_div">
    <button  id="before_edit_to_next">これで選ぶ！</button>
  </div>
</div>

{{-- 全クイズから検索＝検索表示 --}}
{{-- データ送信がないのでtokenもいらずget処理 --}}
<form id="before_edit_from_all"  method="get" action={{route("edit_from_all_route")}}>
</form>

{{-- 言葉から検索 --}}
@include("/quiz/edit/part/from_word_part")


{{-- 条件から検索する場合--}}
{{-- 次で該当クイズリストを表示する --}}
<form id="before_edit_from_case" method="post" action="{{route("edit_from_case_route")}}">
  @csrf
  @include("common/before_play_edit")
  <div class="btn_div">
    <button id="edit_case_btn">上記で検索！</button>
  </div>
</form>

@include("footer")
</x-layout>
