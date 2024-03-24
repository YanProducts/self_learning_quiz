<x-layout>
  <x-slot name="title">クイズを行う</x-slot>
  <x-slot name="js_sets">{{json_encode($js_sets)}}</x-slot>
<h2>どんなクイズをしますか？</h2>

<form id="before_quiz_form" method="post" action="{{route("play_quiz_route")}}">
  @csrf
@include("common/before_play_edit")
<div class="btn_div">
  <button>決定！</button>
</div>
</form>

  @include("footer")

</x-layout>