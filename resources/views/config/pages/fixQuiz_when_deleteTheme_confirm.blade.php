{{-- テーマ削除の際にクイズをどうするか確認ページ --}}
  
<x-layout>
  <x-slot name="title">自習用クイズを作ろう-小テーマ削除確認-</x-slot>
  <x-slot name="js_sets">{{json_encode($js_sets)}}</x-slot>

{{-- リクエストルートが不正だった時 --}}
@error("is_valid")
<p class="if_error0">{!! nl2br(e($message)) !!}</p>
@enderror

<h1 id="fixQuizForDeleteTheme_h1">テーマ削除の調整</h1>

<div id="fixQuizForDeleteTheme_notice">
  <p>
  {{$delete_theme_name}}をテーマに持ち<br class="br600">テーマが１つのクイズがあります。
  <br>クイズ削除または<br class="br600">新テーマ設定の必要があります。
  </p>
</div>


<form action="{{route("quizProcess_when_deleteTheme_route")}}" method="post" id="config_quizWhenDeleteTheme_form" class="config_form config_deleteThemeInQuiz">
    @method("PATCH")
    @csrf
@php
  $li_option_sets=[
    "create"=>"該当クイズに小テーマを新規作成",
    "change"=>"該当クイズを別の小テーマに移動",
    "delete"=>"該当クイズを削除",
  ]
 @endphp
@include("common/li_option_view",["num"=>"first"])


{{-- 新規テーマ--}}
<div id="config_newTheme_whenDelete">
  <div class="config_label_div">
    <p class="config_label">新しいテーマの名前</p>
    <div class="for_inlineForm_div">
    <input type="text" name="new_input_when_delete" value="{{old("move_new_input")}}" id="new_input_when_delete">
    </div>
    @error("new_input_when_delete")
    <input type="hidden" id="validationReturn_newInputWhenDelete">
    <p class="if_error0">{!! nl2br(e($message)) !!}</p>
    @enderror
  </div>
 </div>

 {{-- 既存テーマ --}}
<div id="config_existTheme_whenDelete">
  <div class="config_label_div">
    <p class="config_label">テーマの選択</p>
    <div class="for_inlineForm_div">
    <select name="exist_select_when_delete" id="exist_select_when_delete">
      @php $before_kind="" @endphp
      @foreach($all_themes as $each_theme)
       @if($each_theme->theme_name!==$delete_theme_name)
        @if($before_kind!==$each_theme->kind)
        <optgroup label="{{$each_theme->kind}}">
        @endif
       <option value="{{$each_theme->id}}">{{$each_theme->theme_name}}</option>
       @endif
        @php $before_kind=$each_theme->kind @endphp
      @endforeach
      </select>
    </div>
    @error("exist_select_when_delete")
      <input type="hidden" id="validationReturn_existSelectWhenDelete">
    <p class="if_error0">{!! nl2br(e($message)) !!}</p>
    @enderror
  </div>
 </div>

 {{-- 既存クイズの表示 --}}
 <div id="quizSample_whenDeleteTheme_div">
  <p id="show_quiz_table_p">該当クイズは<span id="show_quiz_table_span">以下</span>の通りです</p>
  <p class="config_label" id="hide_quiz_table_p">閉じる</p>

  <div id="tableSample_whenDeleteTheme">
    {{-- この部分、view_edit_quiz_listsと重複 --}}
    <table>
      <tr>
        <th class="edit_td_title">題名</th>
        <th class="edit_td_quiz">問題</th>
        <th class="edit_td_answer">解答</th>
        <th class="edit_td_ptn">回答</th>
        <th class="edit_td_level">レベル</th>
      <tr>

      @foreach($exist_quizzes as $q)
      <tr class="edit_quiz_what" data-id={{$q->id}}>
        <td class="edit_td_title">{{$q->title}}</td>
        <td class="edit_td_quiz">{{$q->quiz}}</td>
        <td class="edit_td_answer">{{$q->answer}}他</td>
        <td class="edit_td_ptn">{{ intval($q->ptn)===0 ? "あり" : "なし"}}</td>
        <td class="edit_td_level">{{$q->level}}</td>
      </tr>
      @endforeach
    </table>
  </div>

</div>

 {{-- 渡ってきた既存のテーマid(バリデーションの関係でid渡し) --}}
 {{-- コレクション渡しにしないため、クイズリストは渡さない --}}
<input type="hidden" name="delete_theme_id" value="{{$delete_theme_id}}">
 
  <div class="btn_div">
    <button>決定！</button>
  </div>

</form>

@include("footer")

</x-layout>