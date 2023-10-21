<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeforePlay_Request extends FormRequest
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
        return [
            "theme_what"=>"required",
            "answer_which"=>"required|regex:/^[01]$/",
            "level_min"=>"required|integer|between:1,10",
            "level_max"=>"required|integer|between:1,10",
            "percent_min"=>"required|integer|between:0,100",
            "percent_max"=>"required|integer|between:0,100",
        ];
    }

    public function messages(){
        return [
            "theme_what.required"=>"テーマが入力されていません",
            "answer_which.required"=>"回答形式が入力されていません",
            "answer_which.regex"=>"回答形式の値が不正です",
            "level_min.required"=>"レベルが入力されていません",
            "level_max.required"=>"レベルが入力されていません",
            "level_min.integer"=>"レベルの値が不正です",
            "level_max.integer"=>"レベルの値が不正です",
            "level_min.between"=>"レベルの値が不正です",
            "level_max.between"=>"レベルの値が不正です",
            "percent_min.required"=>"正解率が入力されていません",
            "percent_max.required"=>"正解率が入力されていません",
            "percent_min.integer"=>"正解率の値が不正です",
            "percent_max.integer"=>"正解率の値が不正です",
            "percent_min.between"=>"正解率の値が不正です",
            "percent_max.between"=>"正解率の値が不正です",
        ];
    }
}
