<html>
<form id="quiz_submit_form" method="post" action="">
  @csrf

  <div class="quiz_before_select_type">
  <p class="quiz_before_p">テーマは？</p>
    <select id="theme_select_beforequiz" name="theme_what">
      <option value="no_choise" selected>全て</option>
      <option value=""></option>
    </select>
  </div>

  <div class="quiz_before_select_type">
  <p class="quiz_before_p">回答形式は？</p>
    <select id="answer_select_beforequiz" name="answer_which">
      <option value=""></option>
    </select>
  </div>

  <div class="quiz_before_select_type">
  <p class="quiz_before_p">レベルは？</p>
    <div id="level_flex">
    <select class="level_select_beforequiz1" name="level_min">
      <option value=""></option>
    </select>
    〜
    <select class="level_select_beforequiz2" name="level_max">
      <option value=""></option>
    </select>
    </div>
  </div>
  
  </form>
</html>