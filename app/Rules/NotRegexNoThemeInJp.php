<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotRegexNoThemeInJp implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 「テーマなし」という文字列を含んでいたらアウト
        if(preg_match("/テーマなし/u",$value)){
            $fail("大テーマに「テーマなし」の文字は\n含めないでください");
        }
    }
}
