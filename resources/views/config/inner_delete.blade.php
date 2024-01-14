{{-- テーマ削除 --}}

<form action="{{route("delete_theme_route")}}" method="post" id="config_delete_form" class="config_form">

  @method("DELETE")
  @csrf

  {{-- kind_listsに大テーマ、all_listsに小テーマ --}}

</form>