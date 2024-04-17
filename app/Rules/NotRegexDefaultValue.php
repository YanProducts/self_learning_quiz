<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotRegexDefaultValue implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // ptnが選択されていなかったとき（valueに設定しておかなければ、falseと回答必須の0が一緒になってしまうため設定）
        if(preg_match("/^default_value$/u",$value)){
            $fail("選択してください");
        }
    }
}
