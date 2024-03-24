<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Theme;

class InExistThemeId implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //（移動や編集など）themeが既存idだったらOK
        if(!Theme::where("id","=",$value)->exists()){
            $fail("テーマが見当たりません");
        }
    }
}
