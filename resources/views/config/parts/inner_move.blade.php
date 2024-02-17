{{-- テーマ変更 --}}

<form action="{{route("move_theme_route")}}" method="post" id="config_move_form" class="config_form">

  @method("PATCH")
  @csrf

  {{-- いずれにしても開いた状態 --}}
   <div class="config_label_div">
      <p class="config_label">移動する小テーマ</p>
      <div class="for_inlineForm_div">
      <select name="move_before_theme_id" class="config_select_native" id="move_before_theme_select">
        <option hidden value="no_choice">選択してください</option>
         @php $before_kind="" @endphp
        @foreach($all_lists as $theme){
          @if($theme["kind"]!==$before_kind)
            <optgroup label="{{$theme["kind"]}}">
          @endif
          <option value="{{$theme["id"]}}">{{$theme["theme_name"]}}</option> 
         @php $before_kind=$theme["kind"] @endphp
        @endforeach
      </select>
      </div>
  @error("move_before_theme_id")
   <input type="hidden" id="validationReturn_move_beforeThemeId">
   <p class="if_error0">{!! nl2br(e($message)) !!}</p>
  @enderror
</div>      


  <div class="config_label_div">
    <p class="config_label">上記の現在の大テーマ</p>
    <div class="for_inlineForm_div">
      <p class="now_choice_move_theme_default" data-id="">選択されていません</p>
      @foreach($all_lists as $theme)
        <p class="now_choice_move_theme" data-id="{{$theme["id"]}}">{{$theme["kind"]}}</p>
      @endforeach
    </div>
  </div>

  <div class="config_label_div">
      <p class="config_label">移動先は？</p>
          @php
            $li_option_sets=[
              "new"=>"新規",
              "exist"=>"既存",
            ]
         @endphp
        @include("common/li_option_view",["num"=>"third"])
  </div>


    {{-- 新規大テーマ--}}
  <div class="config_move_div">
     <div class="config_label_div">
      <p class="config_label">新しい大テーマの名前</p>
      <div class="for_inlineForm_div">
      <input type="text" name="move_new_input" value="{{old("move_new_input")}}" id="move_new_input">
      </div>
      @error("move_new_input")
      <input type="hidden" id="validationReturn_move_newKind">
      <p class="if_error0">{!! nl2br(e($message)) !!}</p>
      @enderror
    </div>
  </div>

    
      {{-- 既存大テーマへ移動 --}}
  <div class="config_move_div">
    <div class="config_label_div">
        <p class="config_label">移動先の大テーマ</p>
      <div class="for_inlineForm_div">
        <select id="move_before_kind" name="move_before_kind" class="config_select_native" >
          <option hidden value="no_choice">選択してください</option>
          @foreach($kind_lists as $kind)
             <option value="{{$kind}}">{{$kind}}</option>
          @endforeach
        </select>
        </div>
      @error("move_before_kind")
      <input type="hidden" id="validationReturn_move_beforeKind">
      <p class="if_error0">{!! nl2br(e($message)) !!}</p>
      @enderror
    </div>
  </div>

  <div class="btn_div">
    <button>決定！</button>
  </div>
</form>

