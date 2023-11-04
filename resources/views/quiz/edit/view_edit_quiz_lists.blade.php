<x-layout>
  <x-slot name="title">クイズリスト</x-slot>
  <x-slot name="js_sets">{{json_encode($js_sets)}}</x-slot>

  <h2>編集するクイズを選んでください？</h2>

  {{-- 該当するクイズがない時 --}}
  @if(!isset($quiz_lists) || empty($quiz_lists))

  
  @else


  <form id="edit_quiz_decide" method="post" action="{{route("edit_decide_route")}}">
    @csrf
    <table>
    <tr>
      <th>題名</th>
      <th>問題</th>
      <th>解答</th>
      <th>パターン</th>
      <th>テーマ</th>
      <th>レベル</th>
    <tr>

    @foreach($quiz_lists as $q)
    <tr>
      <th>{{$q->title}}</th>
      <th>{{$q->quiz}}</th>
      <th>{{$q->answer}}他</th>
      <th>{{$q->ptn}}</th>
      <th>{{$q->title}}</th>
      <th>{{$q->title}}</th>
    </tr>
    @endforeach

    <select id="edit_decide_id">
    @foreach($quiz_lists as $q)
      <option value="{{$q->id}}"></th>
    @endforeach
    </select>
    </form>

  @endif

</x-layout>