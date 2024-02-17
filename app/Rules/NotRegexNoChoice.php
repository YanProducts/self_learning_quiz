<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotRegexNoChoice implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // no_themeをテーマ登録しない
        if(preg_match("/no_choice/",$value)){
            $fail("テーマにno_choiceの文字は\n加えないでください");
        }
    }
}
