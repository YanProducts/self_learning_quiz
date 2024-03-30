<x-layout>
  <x-slot name="title">エラーのお知らせ</x-slot>
  <x-slot name="js_needless">{{true}}</x-slot>
  <p class="if_error2"><span id="errorPage_title">エラーのお知らせ</span><br>時間切れです</p>
  <div class="back_home"><a href="{{route("indexroute")}}">戻る</a></div>
</x-layout>
