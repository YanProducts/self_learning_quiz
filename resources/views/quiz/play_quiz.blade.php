<x-layout>
  <x-slot name="title">クイズを行う</x-slot>
  <x-slot name="for_js">quiz/play</x-slot>

  <h1>クイズ出題！</h1>

  @if(gettype($first_quiz)==="string" && $first_quiz==="no_quiz")
  <div id="quiz_play_conf">
   <p class="count_zero_p">該当するクイズはありません</p>
  </div>
  @else

  <div id="quiz_play_conf">
    <p>テーマ：{{$theme_view}}
      @if(!empty($theme_other))
      <span id="theme_other">ほか</span>
      @endif
    </p>
   <span id="display_themeother" data-count="{{$count_other}}">{!! nl2br(e($theme_other)) !!}</span>
    <p>レベル：{{$min_level."〜".$max_level}}</p>
    @if($ptn==="0")
    <p>正解率：{{$min_percent."%〜".$max_percent. "%"}}</p>
    @endif
    <p>問題数：{{$quiz_sum_count}}問</p>
  </div>



{{-- 正解不正解時の表示 --}}
@if($ptn==="1")
<div id="display_without">
  <div id="without">
    <p>解答</p>
    <p id="seikai_display"></p>
  </div>
@else
<div id="display_isok">
  <div id="isok_ok">
    <p>正解！</p>
  </div>
  <div id="isok_out">
    <p>不正解…</p>
    <p id="what_is_correct">正解は<span id="seikai_display"></span></p>
  </div>
@endif
  <div class="btn_div2">
    <button id="to_next_question">次の問題へ</button>
  </div>
</div>


{{-- クイズの問題と回答場所 --}}
<form id="play_quiz_corner" method="post" data-action="{{route("to_record_route")}}" action="{{route("to_record_route")}}">
    @csrf  

    <div id="play_title" class="play_each">
      <h3>第<span id="nanmonme">1</span>問</h3>
    </div>


    <div id="play_question" class="play_each">
      <p>問題：<span id="mondai">{{$first_quiz->quiz}}</span></p>
    </div>

    {{-- その問題のテーマなどの表示 --}}
    <div id="change_question_data" class="play_each">
      <p>（
        テーマ：<span id="each_quiz_theme_span">{{$first_quiz->displaytheme}}</span>        
        レベル：<span id="each_quiz_level_span">{{$first_quiz->level}}</span>
        @if($ptn==="0")
        正解率：<span id="each_quiz_percent_span">{{$first_quiz->percent}}％</span>
        @endif
        ）</p>
    </div>  


       {{-- 回答必須かでで分ける --}}
       @if($ptn==="0")
       <div id="play_user_answer" class="play_each">
         <div>回答：<input id="user_answer" name="user_answer"></div>
       </div>
       <div class="btn_div play_each">
         <button id="play_quiz_btn">決定！</button>
       </div>
       @else
        <div class="btn_div play_each">
          <button id="play_quiz_btn">解答へ</button>
        </div> 
     @endif


  <div id="quiz_hidden" 
    data-ptn="{{$ptn}}"
    data-id="{{$first_quiz->id}}"
    data-theme="{{$first_quiz->theme}}"
    data-theme2="{{$first_quiz->theme2}}"
    data-theme3="{{$first_quiz->theme3}}"
    data-level="{{$first_quiz->level}}"
    data-correct="{{$first_quiz->correct}}"
    data-wrong="{{$first_quiz->wrong}}"
    data-answer="{{$first_quiz->answer}}"
    data-answer2="{{$first_quiz->answer2}}"
    data-answer3="{{$first_quiz->answer3}}"
    data-answer4="{{$first_quiz->answer4}}"
    data-answer5="{{$first_quiz->answer5}}"
    data-num={{$num}}
    data-all="{{$all_to_json}}"
    >
    </div>


  </form>

  {{-- 正解と不正解の合計：回答形式のみ --}}
  @if($ptn==="0")
  <div id="play_results">
    <p>正解：<span id="right_sum">0</span>問　不正解：<span id="wrong_sum">0</span>問</p>
  </div>
 @endif

 {{-- エラー時に表示 --}}
  <div id="play_quiz_error">
    <p>ここにエラー文が表示</p>
  </div>

  {{-- 全問終了時 --}}
  <div id="end_of_quiz">
    <p>該当クイズは以上です</p>
    @if($ptn==="0")
     <p>正解：<span id="last_correct_span"></span>問、不正解：<span id="last_wrong_span"></span>問</p>
    @endif
    <p><a href="{{route("before_quiz_route")}}">最初から行う</a></p>
  </div>

 @endif
 @include("footer")

</x-layout>

<script>
  // 非同期通信用
    window.csrf_token = '{{ csrf_token() }}';
</script>