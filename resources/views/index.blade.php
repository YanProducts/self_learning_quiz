<x-layout>
  <x-slot name="title">自習用クイズを作ろう</x-slot>
  <x-slot name="js_sets">{{json_encode($js_sets)}}</x-slot>
<h1>自習用クイズ！</h1>


<form id="what_you_do" method="post" action="{{route("firstroute")}}">
  @csrf

  @include("common/li_option_view",["num"=>"first"])
  
 
  
  <div class="btn_div">
    <button id="index_btn">決定！</button>
  </div>
</form>
</x-layout>