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

            // 作成と編集のどちらか
            $route=request()->route()->getName();

            switch($route){
                case "edit_final_route";
                    // 編集の、かつそのidのみは除外
                    $inputId=request()->input("edit_id");
                    // 同じタイトルのデータがあればバリデーションエラー
                    if(Quiz_list::where([
                        ["title","=",$value],
                        ["id","<>",$inputId]
                    ])->exists())
                    {
                        $fail("そのタイトルは既出です");
                    }
                break;
                case "post_create_route":
                    // 同じタイトルのデータがあればバリデーションエラー
                    if(Quiz_list::where("title","=",$value)->exists()){
                        $fail("そのタイトルは既出です");
                    }
                break;
            }

        }
    }
}
