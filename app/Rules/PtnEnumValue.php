<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Enums\QuizPtn;

class PtnEnumValue implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 条件
        if(!$this->passes($value)){
            $fail($this->message());
        }
    }

    // // ルール
    public function passes($value){
        if(!Quizptn::isValid($value)){
            return false;
        }else{
            return true;
        }
    }

    // // メッセージ
    public function message(){
        return "クイズパターンが未設定です";
    }
}
