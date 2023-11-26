
<h1>クイズの{{$mode}}</h1>

<form action="{{$mode==="編集"  ? route("edit_final_route") :route("post_create_route")}}" method="post" id="quiz_create_form">
  @if($mode==="編集")
    @method("PATCH")
     <input type="hidden" name="edit_id" value="{{old("edit_id") ?? $quiz_for_edit->id}}">
  @endif
 @csrf
 
<div id="quiz_create_title">
<p id="each_quiz_title">タイトル</p>
<input type="text" name="title" placeholder="{{old("title") ?? $mode==="編集" ? $quiz_for_edit->title : ""}}">
</div>
@error("title")
<p class="if_error1">{{$message}}</p>
@enderror


<div id="quiz_create_quiz">
<p id="each_quiz_quiz">クイズ</p>
<textarea name="quiz">{{old("quiz") ?? $mode==="編集" ? $quiz_for_edit->quiz : ""}}</textarea>
</div>
@error("quiz")
<p class="if_error1">{{$message}}</p>
@enderror


<div id="quiz_create_answer1">
<p id="each_quiz_answer1">回答１</p>
<input type="text" name="answer"  placeholder="{{old("answer") ??  $mode==="編集" ? $quiz_for_edit->answer : ""}}">
</div>
@error("answer")
<p class="if_error1">{{$message}}</p>
@enderror


<div id="quiz_create_answer2">
<p id="each_quiz_answer2">回答２<span class="quiz_create_span">省略可</span></p>
<input type="text" name="answer2" placeholder="{{old("answer2") ?? $mode==="編集" ? $quiz_for_edit->answer2 : ""}}">
</div>

<div id="quiz_create_answer3">
<p id="each_quiz_answer3">回答３<span class="quiz_create_span">省略可</span></p>
<input type="text" name="answer3" placeholder="{{old("answer3") ??$mode==="編集" ?  $quiz_for_edit->answer3 : ""}}">
</div>

<div id="quiz_create_answer4">
<p id="each_quiz_answer4">回答４<span class="quiz_create_span">省略可</span></p>
<input type="text" name="answer4" placeholder="{{ old("answer4") ?? $mode==="編集" ?$quiz_for_edit->answer4 : ""}}">
</div>

<div id="quiz_create_answer5">
<p id="each_quiz_answer5">回答５<span class="quiz_create_span">省略可</span></p>
<input type="text" name="answer5"  placeholder="{{old("answer5") ?? $mode==="編集" ? $quiz_for_edit->answer5 : ""}}">
</div>



{{-- バリデーションのold選択がまだ！！ --}}


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

    <li class="quiz_create_each_theme"
    @if($mode==="編集")
      @if(in_array($theme->theme_name,$edit_quiz_themes))
        style="background-color:skyblue"          
      @endif
    @endif
    >{{$theme->theme_name}}</li>
  @endforeach
</ul>
<select id="quiz_create_hidden_select" name="themes[]" multiple>
  @foreach($theme_lists as $theme)
  <option class="quiz_create_hidden_option" value="{{$theme->theme_name}}"
    @if($mode==="編集")
    @if(in_array($theme->theme_name,$edit_quiz_themes))
      selected
    @endif
  @endif
    
    ></option>
  @endforeach
</select>
</div>


<div id="quiz_create_level">
<p id="each_quiz_level">初期レベル</p>
<select id="quiz_create_select_level" name="level">
  <option hidden>選択してください</option>
  @for($n=1;$n<=10;$n++)
    <option class="quiz_create_each_level"
    @if($mode==="編集")
      @if($quiz_for_edit->level===$n)
        selected
      @endif
    @endif
    >{{$n}}</option>
  @endfor
</select>
</div>
@error("level")
<p class="if_error1">{{$message}}</p>
@enderror


<div id="quiz_create_ptn">
<p id="each_quiz_ptn">パターン</p>
<select id="quiz_create_select_ptn" name="ptn">
  <option hidden>選択してください</option>
@foreach($ptn_which as $ptn_key=>$ptn)
  <option value="{{$ptn_key}}"
      @if($mode==="編集")
        @if(intval($quiz_for_edit->ptn)===$ptn_key)
          selected
        @endif
      @endif  
  >{{$ptn}}</option>
@endforeach
</select>
</div>
@error("ptn")
<p class="if_error1">{{$message}}</p>
@enderror

<div class="btn_div">
  <button>決定！</button>
</div>

</form>


