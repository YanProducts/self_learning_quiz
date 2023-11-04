<x-layout>
  <x-slot name="title">自習用クイズを作ろう</x-slot>
  <x-slot name="js_sets">{{json_encode($js_sets)}}</x-slot>
  {{-- エラーメッセージ --}}
@empty(session("Error"))
@else
<p class="if_error1">{{session("Error")}}</p>
@endempty

@empty(session("message"))
@else
<p class="ok_message">{{session("message")}}
@endempty

@error("is_valid")
<p class="if_error1">{{$message}}</p>
@enderror

  <h1>テーマの設定</h1>  

<ul id="theme_ul">
  <li class="theme_li" data-li="make">テーマを作る</li>
  <li class="theme_li" data-li="edit">テーマを編集する</li>
</ul>


<form action="{{route("create_theme_route")}}" method="post" id="config_create_form" class="config_form"
@if($errors->has("new_theme_name"))
style="display:block;"
@endif
}}
>
 @csrf
   <label for="new_name_input">テーマの名前
    <input type="text" name="new_theme_name" id="new_name_input">
  </label>

  @error("new_theme_name")
  <p class="if_error1">{{$message}}</p>
  @enderror
  
  <label for="new_kind_input" class="label_inner1">種類の設定
    <ul id="kind_which">
      <li class="kind_li" data-li="nothing">設定しない</li>
      <li class="kind_li" data-li="new">新しい種類</li>
      <li class="kind_li" data-li="exist">既存の種類</li>
    </ul>
  </label>

  @if(empty($kind_lists) || empty($kind_lists[0]))
  <p class="no_data">種類は設定されていません</p>
  @else
  <label for="new_kind_input">既存種類の追加
      <select id="exist">
        @foreach($kind_lists as $k)
        <option>{{$k}}</option>
        @endforeach
      </select>
    </label>

  @endif


  <label for="new_kind_input">新規種類の追加
    <input type="text" name="new_kind_name" id="new_kind_input">    
  </label>

  <div class="btn_div">
    <button>決定！</button>
  </div>
</form>

{{-- テーマ変更の場合 --}}
<form action="{{route("edit_theme_route")}}" method="post" id="config_edit_form" class="config_form"
@if($errors->has("edit_theme_name"))
style="display:block;"
@endif
>
 @method("PATCH")
 @csrf
 <label for="edit_old_name">変更するテーマ
  <select id="edit_old_theme" name="old_theme_name">
    @foreach ($theme_lists as $theme_name)
    <option value="{{$theme_name}}">{{$theme_name}}</option>   
    @endforeach
  </select>
 </label>

 <label for="edit_name_input">新しいテーマの名前
 <input type="text" name="edit_theme_name" id="edit_name_input">
 </label>
 @error("edit_theme_name")
 <p class="if_error1">{{$message}}</p>
 @enderror
  <div class="btn_div">
    <button>決定！</button>
  </div>
</form>

@include("footer")

</x-layout>