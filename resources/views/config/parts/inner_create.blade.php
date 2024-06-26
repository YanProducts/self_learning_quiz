{{-- テーマを作る --}}
<form action="{{route("create_theme_route")}}" method="post" id="config_create_form" class="config_form"  data-is_submit="yet"
@if($errors->has("new_theme_name"))
style="display:block;"
@endif
>
 @csrf

 <div class="config_label_div">
    <p class="config_label">小テーマの名前</p>
    <div class="for_inlineForm_div">
    <input type="text" name="new_theme_name" id="new_name_input" class="config_themeName_input" value="{{old("new_theme_name")}}">
    </div>
    @error("new_theme_name")
    <input type="hidden" id="validationReturn_newThemeName">
    <p class="if_error0">{!! nl2br(e($message)) !!}</p>
    @enderror
 </div>

<div class="config_label_div">
    <p class="config_label">大テーマの設定</p>
    @php
      $li_option_sets=[
        "no_kind"=>"設定しない",
        "exist"=>"既存の大テーマ",
        "new"=>"新しい大テーマ"
      ]
    @endphp
  @include("common/li_option_view",["num"=>"first"])
  @error("select_first_choice")
  <input type="hidden" id="validationReturn_createKindSelectNone">
  <p class="if_error0">{!! nl2br(e($message)) !!}</p>
  @enderror
</div>

{{-- 選択しない時のhidden要素 --}}
<div class="config_label_div config_kind_div" style="height:0;margin:0;opacity:0;"></div>

  <div class="config_label_div config_kind_div">
    @if(empty($kind_lists) || count($kind_lists)===1 && $kind_lists[0]==="テーマなし")
  <p class="no_data">大テーマはまだ設定されていません</p>
  @else
  <p class="config_label">既存大テーマの追加</p>

  <div class="for_inlineForm_div">
    <select id="exist_kinds_select" class="config_select_native" name="exist_kinds_select">
      <option hidden value="no_choice">選択してください</option>
      @foreach($kind_lists as $k)
        @if($k!=="テーマなし")
            <option value="{{$k}}">{{$k}}</option>
        @endif
      @endforeach
    </select>
    @error("exist_kinds_select")
    <input type="hidden" id="validationReturn_existKindSelect">
    <p class="if_error0">{!! nl2br(e($message)) !!}</p>
    @enderror
  </div>
  @endif
  </div>

  <div class="config_label_div  config_kind_div">
  <p class="config_label">新規大テーマの追加</p>
  <div class="for_inlineForm_div">
    <input type="text" name="new_kind_name" id="new_kind_input" class="config_kindName_input" value="{{old("new_kind_name")}}">
    @error("new_kind_name")
    <input type="hidden" id="validationReturn_newKindName">
    <p class="if_error0">{!! nl2br(e($message)) !!}</p>
    @enderror
   </div>
  </div>

  <div class="btn_div">
    <button>決定！</button>
  </div>
</form>
