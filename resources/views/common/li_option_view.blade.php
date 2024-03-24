<ul id="{{$num}}_ul">
  {{-- 何も選択されずに提出した時のためのhidden --}}
  <li class="{{$num}}_li" style="display:none"></li>
  @foreach($li_option_sets as $key=>$value)
    <li class="{{$num}}_li" data-li="{{$key}}">{{$value}}</li>
  @endforeach
</ul>

<select class="type_select" name="select_{{$num}}_choice" id="select_{{$num}}_choice">
    {{-- 何も選択されずに提出した時のためのhidden --}}
  <option class="{{$num}}_option" value="nothing"></option>
  @foreach($li_option_sets as $key=>$value)
    <option class="{{$num}}_option" value="{{$key}}">{{$value}}</option>
  @endforeach
</select>