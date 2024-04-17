<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\QuizPtn;
use App\Rules\PtnEnumValue;
use App\Rules\NotRegexDefaultValue;

// クイズ作成の例外
class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return
            [
            "title"=>"required",
            "quiz"=>"required|min:3",
            "answer"=>"required|min:1",
            "level"=>["required",new  NotRegexDefaultValue,"integer","min:1","max:10"],
            "ptn"=>["required",new  NotRegexDefaultValue,new PtnEnumValue],
            "themes"=>["required","array","max:3"],
            "themes.*"=>["required","string","not_regex:/^all_themes/u","min:3"]
            ];
    }

    public function messages(){
        return
        [
            "title.required"=>"タイトルが入力されていません",
            "quiz.required"=>"クイズが入力されていません",
            "answer.required"=>"回答が入力されていません",
            "level.required"=>"レベルが入力されていません",
            "ptn.required"=>"回答が入力されていません",
            "quiz.min"=>"クイズが短すぎます",
            "answer.min"=>"回答が短すぎます",
            "level.integer"=>"レベルは数値で記入してください",
            "level.min"=>"レベルは1以上で記入してください",
            "level.max"=>"レベルは10以下で記入してください",
            "themes.required"=>"テーマが入力されていません",
            "themes.array"=>"テーマ形式で予期せぬエラーです",
            "themes.max"=>"テーマは３つ以上選べません",
            "themes.*.required"=>"テーマ形式で予期せぬエラーです",
            "themes.*.string"=>"テーマ形式で予期せぬエラーです",
            "themes.*.not_regex"=>"テーマ名はall_themesから始めないでください",
            "themes.*.min"=>"テーマ名は３文字を超えてください",
        ];
    }


}
