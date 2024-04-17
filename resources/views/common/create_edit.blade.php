<x-layout>
  <x-slot name="title">クイズの{{$mode}}</x-slot>
  <x-slot name="js_sets">{{json_encode($js_sets)}}</x-slot>

<h1>クイズの{{$mode}}</h1>

@error("edit_id")
  <p class="if_error0">{!! nl2br(e($message)) !!}</p>
@enderror

{{-- 削除の場合の隠れフォーム --}}
@if($mode==="編集")
    <form action="{{route("quiz_delete_route")}}" id="ifQuizDeleteForm" method="post">
     @method("DELETE")
     @csrf
     <input type="hidden" name="edit_quiz_decide" value="{{old("edit_quiz_decide") ?? $quiz_for_edit->id}}">
    </form>
 @endif



<form action="{{$mode==="編集"  ? route("edit_final_route") :route("post_create_route")}}" method="post" id="quiz_create_form">
  @if($mode==="編集")
    @method("PATCH")
     <input type="hidden" name="edit_id" value="{{old("edit_id") ?? $quiz_for_edit->id}}">
  @endif
 @csrf

 {{-- 削除の場合のUI --}}
 @if($mode==="編集")
    <div id="ifQuizDeletePattern">
        <p>このクイズを削除する場合は<br class="br500"><span id="ifQuizDeletePatternSpan">こちら</span>をクリック</p>
    </div>
    @error("edit_id")
    <p class="if_error0">{!! nl2br(e($message)) !!}</p>
    @enderror
 @endif


<div id="quiz_create_title">
<p id="each_quiz_title">タイトル</p>
<input type="text" name="title" value="{{old("title", $mode==="編集" ? $quiz_for_edit->title : "")}}">
</div>
@error("title")
 <p class="if_error0">{!! nl2br(e($message)) !!}</p>
@enderror


<div id="quiz_create_quiz">
<p id="each_quiz_quiz">クイズ</p>
<textarea name="quiz">{{old("quiz", $mode==="編集" ? $quiz_for_edit->quiz : "")}}</textarea>
</div>
@error("quiz")
<p class="if_error0">{!! nl2br(e($message)) !!}</p>
@enderror


<div id="quiz_create_answer1">
<p id="each_quiz_answer1">回答１</p>
<input type="text" name="answer" value="{{old("answer", $mode==="編集" ? $quiz_for_edit->answer : "")}}">
</div>
@error("answer")
<p class="if_error0">{!! nl2br(e($message)) !!}</p>
@enderror


<div id="quiz_create_answer2">
<p id="each_quiz_answer2">回答２<span class="quiz_create_span">省略可</span></p>
<input type="text" name="answer2" value="{{old("answer2", $mode==="編集" ? $quiz_for_edit->answer2 : "")}}">
</div>

<div id="quiz_create_answer3">
<p id="each_quiz_answer3">回答３<span class="quiz_create_span">省略可</span></p>
<input type="text" name="answer3" value="{{old("answer3", $mode==="編集" ?  $quiz_for_edit->answer3 : "")}}">
</div>

<div id="quiz_create_answer4">
<p id="each_quiz_answer4">回答４<span class="quiz_create_span">省略可</span></p>
<input type="text" name="answer4" value="{{ old("answer4", $mode==="編集" ?$quiz_for_edit->answer4 : "")}}">
</div>

<div id="quiz_create_answer5">
<p id="each_quiz_answer5">回答５<span class="quiz_create_span">省略可</span></p>
<input type="text" name="answer5" value="{{old("answer5", $mode==="編集" ? $quiz_for_edit->answer5 : "")}}">
</div>


<div id="quiz_create_theme">

<p id="each_quiz_theme">テーマ<span class="quiz_create_span">（1つ〜３つ）</span></p>
@error("themes")
<p class="if_error0">{!! nl2br(e($message)) !!}</p>
@enderror
@error("themes.*")
<p class="if_error0">{!! nl2br(e($message)) !!}</p>
@enderror
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

    <li class="quiz_create_each_theme"
      @if(
      (old("themes") && in_array($theme->theme_name,old("themes"))) ||
      ($mode==="編集" && in_array($theme->theme_name,$edit_quiz_themes))
      )
          style="background-color:skyblue"
      @endif
    >{{$theme->theme_name}}</li>
  @endforeach
</ul>
<select id="quiz_create_hidden_select" name="themes[]" multiple>
  @foreach($theme_lists as $theme)
  <option class="quiz_create_hidden_option" value="{{$theme->theme_name}}"
    @if(
      (old("themes") && in_array($theme->theme_name, old("themes"))) ||
      ($mode==="編集" && in_array($theme->theme_name,$edit_quiz_themes))
      )
        selected
    @endif
    ></option>
  @endforeach
</select>
</div>


<div id="quiz_create_level">
<p id="each_quiz_level">初期レベル</p>
<select id="quiz_create_select_level" name="level">
  <option hidden value="default_value">選択してください</option>
  @for($n=1;$n<=10;$n++)
    <option class="quiz_create_each_level"
      @if((old("level") && strval(old("level"))===strval($n)) || ($mode==="編集" &&$quiz_for_edit->level===$n) )
        selected
    @endif
    >{{$n}}</option>
  @endfor
</select>
</div>
@error("level")
<p class="if_error0">{!! nl2br(e($message)) !!}</p>
@enderror

<div id="quiz_create_ptn">
<p id="each_quiz_ptn">パターン</p>
<select id="quiz_create_select_ptn" name="ptn">
  <option hidden value="default_value">選択してください</option>
@foreach($ptn_which as $ptn_key=>$ptn)
  <option value="{{$ptn_key}}"
  {{-- ptnは回答必須の場合は0選択になるのでfalseとされる。そのため、第一条件はold("level")で記入。levelはpostがあれば必ず存在する --}}
      @if((old("level") && old("ptn")!=="default_value" && intval(old("ptn"))===intval($ptn_key)) || ($mode==="編集" && intval($quiz_for_edit->ptn)===intval($ptn_key)))
          selected
      @endif
  >{{$ptn}}</option>
@endforeach
</select>
</div>
@error("ptn")
<p class="if_error0">{!! nl2br(e($message)) !!}</p>
@enderror

<div class="btn_div">
  <button>決定！</button>
</div>

</form>

@include("footer")
</x-layout>
