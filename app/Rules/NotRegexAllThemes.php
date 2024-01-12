<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotRegexAllThemes implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
       //all_themeで始まっていたらfail
       if(mb_substr($value,0,9)==="all_theme"){
        $fail("all_themesから始めないでください");
    }
    }
}
