<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\inExistQuizId;

class EditQuizRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "edit_quiz_decide"=>[
            "required",
            "integer",
            new inExistQuizId
             ]
         ];
    }

    public function messages(){
        return
            [
            "edit_quiz_decide.required"=>"選択されていません",
            "edit_quiz_decide.integer"=>"入力データが不正です",
            ];
    }
}
