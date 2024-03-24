<?php
    namespace App\Rules;
    
    use Closure;
    use Illuminate\Contracts\Validation\ValidationRule;
    use App\Models\Theme;
    
    class InExistKind implements ValidationRule
    {

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */


        // Laravel10より変更。初期状態で、requestでnew ...で投げられたら、このvalidateに渡る。attributeは属性、valueは値,failは失敗時に自動的に実行。voidなのでreturnしない
        public function validate(string $attribute, mixed $value, Closure $fail): void
        {
            if(!in_array($value,Theme::groupBy("kind")->pluck("kind")->toArray())){
                $fail("大テーマが見当たりません");
            }
        }

    }
    
