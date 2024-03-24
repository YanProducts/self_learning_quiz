
<x-layout>
<x-slot name="title">お知らせ</x-slot>
{{-- jsは必要ない --}}
<x-slot name="js_needless">{{True}}</x-slot>
<div id="finish_sign">
  {{-- リダイレクト時の２重登録防止 --}}
  @if(session("is_error") && session("is_error")==="error")
    <p  class="finish_p">
        {!! nl2br("エラーです\n".session("naiyou")) !!}
    </p>
  @else

  {{-- redirectで渡した変数はリロードしたら削除される --}}
    @if(empty(session("pageRoute") || empty(session("naiyou"))))
  
    @else
      <p  class="finish_p">
          {!! nl2br(session("naiyou")) !!}
      </p>
      <p class="back_home_inner"><a href="{{route(session("pageRoute"))}}">戻る</a></p>
      @endif
  @endif

  <p class="back_home_inner"><a href="{{route("indexroute")}}">トップページへ</a></p>
</div>
</x-layout>