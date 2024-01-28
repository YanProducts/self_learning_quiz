{{-- テーマ削除 --}}

<form action="{{route("delete_theme_route")}}" method="post" id="config_delete_form" class="config_form">

  @method("DELETE")
  @csrf


{{-- 何を消去するか？ --}}
  <div class="config_label_div">
    <p class="config_label">消去するのは？</p>
        @php
          $li_option_sets=[
            "kind"=>"大テーマの消去",
            "theme"=>"小テーマの消去",
          ]
       @endphp
      @include("common/li_option_view",["num"=>"fourth"])
  </div>


    {{-- 大テーマリスト --}}
    <div class="config_delete_div">
       <div class="config_label_div">
            <p class="config_label">大テーマを選んでください</p>
          <div class="for_inlineForm_div">
            <select id="delete_kind" name="delete_kind" class="config_select_native" >
              <option hidden value="no_choice">選択してください</option>
              @foreach($kind_lists as $kind)
               @if($kind!=="テーマなし")
                 <option value="{{$kind}}">{{$kind}}</option>
               @endif
              @endforeach
            </select>
            </div>
        </div>
     </div>
    
  {{-- 小テーマリスト --}}
  <div class="config_delete_div">
   <div class="config_label_div">
    <p class="config_label">小テーマを選んでください</p>
    <div class="for_inlineForm_div">
    <select name="delete_theme_id" class="config_select_native" id="move_before_theme_select">
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
 </div>

 <div class="btn_div">
  <button>決定！</button>
</div>

</form>