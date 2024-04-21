  <div class="quiz_before_select_type" id="quiz_before_themelist">
  <p class="quiz_before_p">テーマは？(＊複数選択可)
  </p>
  @error("theme_what")<p class="if_error1">{{$message}}</p>@enderror

  {{-- 裏select用 --}}
    <select id="theme_select_beforequiz" name="theme_what[]" multiple>
      <option class="beforequiz_theme_hidden0" value="all_themes"></option>
      <?php $before_kind="" ?>
      @foreach($theme_lists as $tl)
       @if($tl["kind"]!==$before_kind)
       <?php $large_theme=!empty($tl["kind"]) ? $tl["kind"] : "分類なし" ?>
        <option class="beforequiz_theme_hidden0" data-kind="{{$large_theme}}" value="all_themes_{{$large_theme}}"></option>
       @endif
      <option  class="beforequiz_theme_hidden" data-kind="{{$large_theme}}" value="{{$tl["theme_name"]}}"></option>
       <?php $before_kind=$tl["kind"] ?>
      @endforeach
    </select>

    {{-- UI用 --}}
    <ul id="theme_ui_ul">
      <li class="beforequiz_theme_li0" data-value="all_themes">　全テーマ</li>
      <?php $before_kind="" ?>
      @foreach($theme_lists as $tl)
       @if($tl["kind"]!==$before_kind)
       <?php $large_theme=!empty($tl["kind"]) ? $tl["kind"] : "分類なし" ?>
        <li  class="no_choice_li">{{$large_theme}}</li>
        <li  class="beforequiz_theme_li0" data-kind="{{$large_theme}}" data-value="all_themes_{{$large_theme}}">　{{$large_theme}}の全テーマ</li>
       @endif
        <li  class="beforequiz_theme_li" data-kind="{{$large_theme}}" data-value="{{$tl["theme_name"]}}">　{{$tl["theme_name"]}}</li>
       <?php $before_kind=$tl["kind"] ?>
      @endforeach
    </ul>
  </div>


  <fieldset id="now_choice_theme_field">
      <legend>現在選択中テーマ</legend>
      <p id="now_choice_themes">選択なし</p>
  </fieldset>


  <div class="quiz_before_select_type">
  <p class="quiz_before_p">回答形式は？</p>
  @error("answer_which")<p class="if_error1">{{$message}}</p> @enderror
    <select id="answer_select_beforequiz" name="answer_which">
      <?php $ptn_n=0; ?>
      @foreach($ptn_which as $ptn)
        <option value="{{$ptn_n}}">{{$ptn}}</option>
        <?php $ptn_n++; ?>
      @endforeach
    </select>
  </div>

  <div class="quiz_before_select_type" id="quiz_before_levels">
  <p class="quiz_before_p">レベルは？</p>

  @if($errors->has("level_min") || $errors->has("level_max"))
    <p class="if_error1">{{$message}}</p>
  @endif

  <div class="level_percent_flex">
    <select id="level_select_beforequiz1" name="level_min">
      @for($min=1;$min<=10;$min++)
      <option value="{{$min}}" @if($min===1) selected @endif>{{$min}}</option>
      @endfor
    </select>
    <span>〜</span>
    <select id="level_select_beforequiz2" name="level_max">
      @for($max=1;$max<=10;$max++)
       <option value="{{$max}}" @if($max===10) selected @endif>{{$max}}</option>
      @endfor
    </select>
    </div>
  </div>

  <div class="quiz_before_select_type" id="quiz_before_percents">
  <p class="quiz_before_p">正解率は？<span class="level_choice_span">(@if($mode==="編集") 未出題は選択されます @else 未出題は0%で計算 @endif )</span></p>

  @if($errors->has("percent_min") || $errors->has("percent_max"))
    <p class="if_error1">{{$message}}</p>
  @endif

    <div class="level_percent_flex">
    <select id="percent_select_beforequiz1" name="percent_min">
      @for($min=0;$min<=100;$min++)
      <option value="{{$min}}"  @if($min===0) selected @endif>{{$min}}</option>
      @endfor
    </select>
    <span>〜</span>
    <select id="percent_select_beforequiz2" name="percent_max">
      @for($max=0;$max<=100;$max++)
       <option value="{{$max}}"  @if($max===100) selected @endif>{{$max}}</option>
      @endfor
    </select>
    </div>
  </div>

