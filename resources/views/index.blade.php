<x-layout>
  <x-slot name="title">自習用クイズを作ろう</x-slot>
  <x-slot name="for_js">index</x-slot>
<h1>自習用クイズ！</h1>


<form id="what_you_do" method="post" action="{{route("firstroute")}}">
  @csrf
  
  <ul id="first_ul">
    <li class="first_li" data-li="play">クイズを行う</li>
    <li class="first_li" data-li="make">クイズを作る</li>
    <li class="first_li" data-li="edit">クイズを編集/削除する</li>
    <li class="first_li" data-li="config">テーマを編集する</li>
  </ul>

  <select id="type_select" name="select_first_choise">
    <option class="first_option" value="play">クイズを行う</option>
    <option class="first_option" value="make">クイズを作る</option>
    <option class="first_option" value="edit">クイズを編集/削除する</option>
    <option class="first_option" value="config">テーマを編集する</option>
  </select>
  
  <div class="btn_div">
    <button>決定！</button>
  </div>
</form>
</x-layout>