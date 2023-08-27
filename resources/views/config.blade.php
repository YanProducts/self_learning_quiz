<x-layout>
  <x-slot name="title">自習用クイズを作ろう</x-slot>
  <x-slot name="for_js">config</x-slot>

  {{-- エラーメッセージ --}}
@empty(session("Error"))
@else
<p class="if_error">{{session("Error")}}</p>
@endempty

@empty(session("message"))
@else
<p class="ok_message">{{session("message")}}
@endempty



  <h1>テーマの設定</h1>  

<ul id="theme_ul">
  <li class="theme_li" data-li="play">テーマを作る</li>
  <li class="theme_li" data-li="make">クイズを編集する</li>
</ul>


<form action="{{route("create_theme_route")}}" method="post" id="config_create_form" class="config_form">
 @csrf
   <label for="new_name_input">テーマの名前
    <input type="text" name="new_theme_name" id="new_name_input">
   </label>
  <div class="btn_div">
    <button>決定！</button>
  </div>
</form>

<form action="{{route("edit_theme_route")}}" method="post" id="config_edit_form" class="config_form">
 @method("PATCH")
 @csrf
 <label for="edit_old_name">変更するテーマ
  <select id="edit_old_theme" name="edit_select">
    <option value="">a</option>
    <option value="">b</option>
    <option value="">c</option>
  </select>
 </label>

 <label for="edit_name_input">新しいテーマの名前
 <input type="text" name="new_theme_name" id="edit_name_input">
 </label>
  <div class="btn_div">
    <button>決定！</button>
  </div>
</form>


</x-layout>