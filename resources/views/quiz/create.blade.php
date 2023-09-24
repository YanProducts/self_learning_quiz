
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif




<x-layout>
  <x-slot name="title">自習用クイズを作ろう</x-slot>
  <x-slot name="for_js">quiz/create</x-slot>

  <h1>クイズの作成</h1>

<form action="{{route("post_create_route")}}" method="post" id="quiz_create_form">
 @csrf

<div id="quiz_create_title">
<p id="each_quiz_title">タイトル</p>
<input type="text" name="title">
</div>
@error("title")
{{$message}}
@enderror


<div id="quiz_create_quiz">
<p id="each_quiz_quiz">クイズ</p>
<textarea name="quiz"></textarea>
</div>
@error("quiz")
{{$message}}
@enderror


<div id="quiz_create_answer1">
<p id="each_quiz_answer1">回答１</p>
<input type="text" name="answer">
</div>
@error("answe1")
{{$message}}
@enderror


<div id="quiz_create_answer2">
<p id="each_quiz_answer2">回答２<span class="quiz_create_span">省略可</span></p>
<input type="text" name="answer2">
</div>

<div id="quiz_create_answer3">
<p id="each_quiz_answer3">回答３<span class="quiz_create_span">省略可</span></p>
<input type="text" name="answer3">
</div>

<div id="quiz_create_answer4">
<p id="each_quiz_answer4">回答４<span class="quiz_create_span">省略可</span></p>
<input type="text" name="answer4">
</div>

<div id="quiz_create_answer5">
<p id="each_quiz_answer5">回答５<span class="quiz_create_span">省略可</span></p>
<input type="text" name="answer5">
</div>

<div id="quiz_create_theme">
<p id="each_quiz_theme">テーマ<span class="quiz_create_span">３つまで選択可能</span></p>
<ul id="quiz_create_select_theme">
  {{-- 種類で区分け --}}
  @foreach($theme_lists as $theme)
    @if($theme->kind!==$default_kind)
     <li class="quiz_create_each_kind">
      @empty($theme->kind)
        テーマなし
      @else
        {{$theme->kind}}
      @endempty
     </li>
    <?php $default_kind=$theme->kind ?>
    {{-- orderbyで種類ごとに区分けされている --}}
    @endif
    <li class="quiz_create_each_theme">{{$theme->theme_name}}</li>
  @endforeach
</ul>
<select id="quiz_create_hidden_select" name="themes" multiple>
  @foreach($theme_lists as $theme)
  <option class="quiz_create_hidden_option" value="{{$theme->theme_name}}"></option>
  @endforeach
</select>
</div>


<div id="quiz_create_level">
<p id="each_quiz_level">初期レベル</p>
<select id="quiz_create_select_level" name="level">
  <option hidden>選択してください</option>
  @for($n=1;$n<10;$n++)
    <option class="quiz_create_each_level">{{$n}}</option>
  @endfor
</select>
</div>
@error("level")
{{$message}}
@enderror

<div id="quiz_create_level">
<p id="each_quiz_level">パターン</p>
<select id="quiz_create_select_ptn" name="ptn">
  <option hidden>選択してください</option>
@foreach($ptn_which as $ptn_key=>$ptn)
  <option value="{{$ptn_key}}">{{$ptn}}</option>
@endforeach
</select>
</div>

<div class="btn_div">
  <button>決定！</button>
</div>

</form>

@include("footer")

</x-layout>