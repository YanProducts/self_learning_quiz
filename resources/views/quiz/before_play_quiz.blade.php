<x-layout>
  <x-slot name="title">クイズを行う</x-slot>
  <x-slot name="js_needless">{{True}}</x-slot>

<h2>どんなクイズをしますか？</h2>

<form id="before_quiz_form" method="post" action="{{route("play_quiz_route")}}">
  @csrf
  <div class="quiz_before_select_type">
  <p class="quiz_before_p">テーマは？(＊複数選択可)
  </p>
    <select id="theme_select_beforequiz" name="theme_what[]" multiple>
      <option value="all_themes" selected>全て</option>
      <?php $before_kind="" ?>
      @foreach($theme_lists as $tl)
       @if($tl["kind"]!==$before_kind)
        <optgroup label="{{!empty($tl["kind"]) ? $tl["kind"] : "未分類"}}"></optgroup>
       @endif
       <option value="{{$tl["theme_name"]}}">{{$tl["theme_name"]}}</option>
       <?php $before_kind=$tl["kind"] ?>
      @endforeach
    </select>
  </div>

  <div class="quiz_before_select_type">
  <p class="quiz_before_p">回答形式は？</p>
    <select id="answer_select_beforequiz" name="answer_which">
      <?php $ptn_n=0; ?>
      @foreach($ptn_which as $ptn)
        <option value="{{$ptn_n}}">{{$ptn}}</option>
        <?php $ptn_n++; ?>
      @endforeach
    </select>
  </div>

  <div class="quiz_before_select_type">
  <p class="quiz_before_p">レベルは？</p>
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

  <div class="quiz_before_select_type">
  <p class="quiz_before_p">正解率は？</p>
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

  <div class="btn_div">
    <button>決定！</button>
  </div>
  
  </form>

  @include("footer")

</x-layout>