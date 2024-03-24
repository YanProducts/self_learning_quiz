<x-layout>
  <x-slot name="title">自習用クイズを作ろう-設定-</x-slot>
  <x-slot name="js_sets">{{json_encode($js_sets)}}</x-slot>

@empty(session("message"))
@else
<p class="ok_message">{{session("message")}}
@endempty

{{-- リクエストルートが不正だった時 --}}
@error("is_valid")
<p class="if_error0">{!! nl2br(e($message)) !!}</p>
@enderror

  <h1>テーマの設定</h1>

<ul id="theme_ul">
  <li class="theme_li" data-li="make">テーマを作る</li>
  <li class="theme_li" data-li="edit">テーマ名を編集する</li>
  <li class="theme_li" data-li="move">小テーマの大テーマを移動</li>
  <li class="theme_li" data-li="delete">テーマを削除する</li>

</ul>


{{-- 小テーマが1つも設定されていないときのjs反応用 --}}
{{-- include内のvalidationリターンの都合上、includeしないという手立ては取れない --}}
 @if(count($theme_lists)===0)
 <input type="hidden" id="ifThemeDoesNotExists">
 @endif

 {{-- 大テーマが1つも設定されていないときのjs反応用 --}}
 @if(count($kind_lists)===0)
  <input type="hidden" id="ifKindDoesNotExists">
 @endif

{{-- テーマを作る --}}
@include("config/parts/inner_create",["kind_lists"=>$kind_lists])

{{-- テーマを変更する --}}
@include("config/parts/inner_change",["kind_lists"=>$kind_lists,"all_lists"=>$all_lists])

{{-- 大テーマを移動 --}}
@include("config/parts/inner_move",["kind_lists"=>$kind_lists,"all_lists"=>$all_lists])

{{-- テーマを削除する --}}
@include("config/parts/inner_delete",["kind_lists"=>$kind_lists,"all_lists"=>$all_lists])

@include("footer")

</x-layout>
