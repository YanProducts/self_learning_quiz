<x-layout>
  <x-slot name="title">編集ページ</x-slot>
  <x-slot name="js_sets">{{json_encode($js_sets)}}</x-slot>

  @include("../../common/create_edit")

@include("footer")
</x-layout>