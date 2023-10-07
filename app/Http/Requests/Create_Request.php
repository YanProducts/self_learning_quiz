<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\QuizPtn;
use App\Rules\PtnEnumValue;

class Create_Request extends FormRequest
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
            "level"=>"required|integer",
            "ptn"=>["required",new PtnEnumValue]
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
            "level.integer"=>"レベルは数値で記入してください"
        ];
    }


}
