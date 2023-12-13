<ul id="first_ul">
  <li class="first_li" style="display:none"></li>
  @foreach($li_option_sets as $key=>$value)
    <li class="first_li" data-li="{{$key}}">{{$value}}</li>
  @endforeach
</ul>

<select id="type_select" name="select_first_choise">
  <option class="first_option" value="nothing"></option>
  @foreach($li_option_sets as $key=>$value)
    <option class="first_option" value="{{$key}}">{{$value}}</option>
  @endforeach
</select>