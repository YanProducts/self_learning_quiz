<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Quiz_list;

// 作成or編集クイズが既に作成済みのタイトルだったらアウト
class NotInExistTitle implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //クイズがそもそもあるか
        if(Quiz_list::exists()){
            // 同じタイトルのデータがあればバリデーションエラー
            if(Quiz_list::where("title","=",$value)->exists()){
                $fail("そのタイトルは既出です");
            }
        }
    }
}
