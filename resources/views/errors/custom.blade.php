<x-layout>
  <x-slot name="title">エラーのお知らせ</x-slot>
  <x-slot name="js_needless">{{true}}</x-slot>
  <div class="if_error2_div">
    <p class="if_error2">エラーのお知らせ<br>{{$message}}</p>
  </div>
  <div class="back_home"><a href="{{route("indexroute")}}">戻る</a></div>
</x-layout>