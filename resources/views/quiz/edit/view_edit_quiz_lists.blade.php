<x-layout>
  <x-slot name="title">クイズリスト</x-slot>
   <x-slot name="js_sets">{{json_encode($js_sets)}}</x-slot>

  <h2  class="h2WithBr500">編集または削除するクイズを<br class="br500">選んでください</h2>

  {{-- 該当するクイズがない時 --}}
  @if($quiz_lists->isEmpty())
  <p id="edit_hit_none">該当クイズはありません</p>
  @else
  <p id="edit_choice_count">当てはまるクイズは{{count($quiz_lists)}}問です</p>

  <form id="edit_quiz_decide" method="post" action="{{route("edit_decide_route")}}">
    @csrf

    @error("edit_quiz_decide")
    <p class="if_error1">{{$message}}</p>
    @enderror


    <table>

    <tr>
      <th class="edit_td_title">題名</th>
      <th class="edit_td_quiz">問題</th>
      <th class="edit_td_answer">解答</th>
      <th class="edit_td_ptn">回答</th>
      <th class="edit_td_theme">テーマ</th>
      <th class="edit_td_level">レベル</th>
    <tr>

    @foreach($quiz_lists as $q)
    <tr class="edit_quiz_what" data-id={{$q->id}}>
      <td class="edit_td_title">{{$q->title}}</td>
      <td class="edit_td_quiz">{{$q->quiz}}</td>
      <td class="edit_td_answer">{{$q->answer}}他</td>
      <td class="edit_td_ptn">{{ intval($q->ptn)===0 ? "あり" : "なし"}}</td>
      <td class="edit_td_theme">{{$q->theme_name."他" ?? "なし"}}</td>
      <td class="edit_td_level">{{$q->level}}</td>
    </tr>
    @endforeach
  </table>

   {{-- クイズは１０個ずつ表示 --}}
   <input type="hidden" id="table_view_number" value="0">
  {{-- どのページを表示させるか？ --}}
  @if($quiz_lists->isNotEmpty())
    <div id="edit_view_10quiz">
        <span id="edit_view_10quiz_toBefore">&lt;&lt;前の10件</span>
        <span id="edit_view_10quiz_toAfter">次の10件&gt;&gt;</span>
    </div>
@endif
    <input id="hidden_edit_quiz_decide" type="hidden" name="edit_quiz_decide" value="">

    <div class="btn_div">
      <button  id="edit_to_viewquiz">これを編集/削除！</button>
    </div>

  </form>

  @endif

  @include('footer')

</x-layout>
