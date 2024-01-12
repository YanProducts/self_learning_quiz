<x-layout>
  <x-slot name="title">自習用クイズを作ろう</x-slot>
  <x-slot name="js_sets">{{json_encode($js_sets)}}</x-slot>
  {{-- エラーメッセージ --}}
@empty(session("Error"))
@else
<p class="if_error0">{{session("Error")}}</p>
@endempty

@empty(session("message"))
@else
<p class="ok_message">{{session("message")}}
@endempty

@error("is_valid")
<p class="if_error0">{{$message}}</p>
@enderror

  <h1>テーマの設定</h1>  

<ul id="theme_ul">
  <li class="theme_li" data-li="make">テーマを作る</li>
  <li class="theme_li" data-li="edit">テーマを編集する</li>
</ul>


{{-- テーマを作る --}}
@include("config/inner_create",["kind_lists"=>$kind_lists])


{{-- テーマを変更する --}}
@include("config/inner_change",["kind_lists"=>$kind_lists,"all_lists"=>$all_lists])


@include("footer")

</x-layout>