<!DOCTYPE HTML>
<html lang="ja">

<head>
  <meta charset="utf8">
  <meta name="description" contents="width=device-width;initial-scale=1;user-scalable=no;">
  <title>{{$title}}</title>
  <link rel="stylesheet" href="{{url("css/styles.css")}}">
   <!-- gzipを解凍できるpacoライブラリの読み込み -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pako/1.0.11/pako.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

  {{-- jsがいらない時を省く --}}
  {{-- jsはbladeで配列をセット --}}
  @if(!isset($js_needless) || !$js_needless)
   @foreach(json_decode(html_entity_decode($js_sets)) as $js)
   <script defer src="{{ url("js/${js}.js")}}"
   ></script>
   @endforeach
  @endif
</head>

<body>

{{$slot}}      

</body>
</html>