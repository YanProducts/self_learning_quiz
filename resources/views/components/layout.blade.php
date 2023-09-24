<!DOCTYPE HTML>
<html lang="ja">

<head>
  <meta charset="utf8">
  <meta name="description" contents="width=device-width;initial-scale=1;user-scalable=no;">
  <title>{{$title}}</title>
  <link rel="stylesheet" href="{{url("css/styles.css")}}">
  <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

  {{-- jsがいらない時 --}}
  @if(!isset($js_needless) || !$js_needless)
   <script defer src="{{ url("js/${for_js}.js")}}"></script>
  @endif
</head>

<body>

{{$slot}}      

</body>
</html>