<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Theme;

class NotInExistKind implements ValidationRule
{
        /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    
  // Laravel10より変更。初期状態で、requestでnew ...で投げられたら、このvalidateに渡る。attributeは属性、valueは値,failは失敗時に自動的に実行。voidなのでreturnしない
  public function validate(string $attribute, mixed $value, Closure $fail): void
  {
      if(in_array($value,Theme::groupBy("kind")->pluck("kind")->toArray())){
          $fail("大テーマが重複しています");
      }
  }

    // // 初期状態で、requestでnew ...で投げられたら、このpassに渡る。attributeは属性、valueは値
    // public function passes(){
    //     //toArrayは空の場合は空の配列を返してくれる（エラーにならない）ので初期状態でも大丈夫
    //     return !in_array($value,Theme::groupBy("kind")->pluck("kind")->toArray());
    // }

    // // // メッセージ
    // public function messages(){
    //     return "テーマが重複しています";
    // }

}
