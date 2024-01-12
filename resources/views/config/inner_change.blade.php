{{-- テーマ変更の場合 --}}


<form action="{{route("edit_theme_route")}}" method="post" id="config_edit_form" class="config_form">
  @method("PATCH")
  @csrf
 
 
 <div class="config_label_div">
     <p class="config_label">変更する内容</p>
     @php
       $li_option_sets=[
         "theme"=>"小テーマ",
         "kind"=>"大テーマ",
       ]
    @endphp
   @include("common/li_option_view",["num"=>"second"])
 </div>
 
 @foreach($li_option_sets as $key=>$value)
 {{-- テーマ、大テーマの編集 --}}
 <div class="config_edit_div">
   <div class="config_label_div">
   <p class="config_label">変更する{{$value}}</p>
   <div class="for_inlineForm_div">
   <select id="old_{{$key}}_name" name="old_{{$key}}_name" class="config_select_native" >
     <option hidden value="no_choice">選択してください</option>
     @if($key==="kind")
       @foreach ($kind_lists as $name)
       <option value="{{$name}}">{{$name}}</option>   
       @endforeach
     @endif
 
     @if($key==="theme")
       @php $before_kind="" @endphp
         @foreach ($all_lists as $name)
           @if($before_kind!==$name["kind"])
             <optgroup label="{{$name["kind"]}}">
           @endif
           <option value="{{$name["id"]}}">{{$name["theme_name"]}}</option>
           @php $before_kind=$name["kind"] @endphp
         @endforeach
     @endif 
  
   </select>
   </div>
   </div>
 
   <div class="config_label_div">
   <p class="config_label">新しい{{$value}}の名前</p>
   <div class="for_inlineForm_div">
   <input type="text" name="edit_{{$key}}_name" value="{{old("edit_.$key._name")}}" id="edit_{{$key}}_name"
   class="config_{{$key}}Name_input">
   </div>
   </div>
 
   @error("edit_{{$key}}_name")
   <input type="hidden" id="validationReturn_edit_{{$key}}Name">
   <p class="if_error0">{{$message}}</p>
   @enderror
 
 </div>
 @endforeach
 
 
 
   <div class="btn_div">
     <button>決定！</button>
   </div>
 </form>