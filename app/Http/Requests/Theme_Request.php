<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Theme_Request extends FormRequest
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
        if(request()->route()->getName()==="new_theme_route"){
            return [
                "new_theme_name"=>[
                    "required",
                    "regex:/^[^,、]+$/u"
                ]];
        }else if(request()->route()->getName()==="edit_theme_route2"){
            return [
                "edit_theme_name"=>[
                "required",
                "regex:/^[^,、]+$/u"
                ]];
        }else{
            // 不正な処理
            return [
                // 存在しない値を設定
                "is_valid"=>"required"
            ];
        }
    }
    public function messages(){
        return[
            "new_theme_name.required"=>"テーマは入力必須です",
            "edit_theme_name.required"=>"テーマは入力必須です",
            "new_theme_name.regex"=>"テーマにカンマはつけないでください",
            "edit_theme_name.regex"=>"テーマにカンマはつけないでください",
            "is_valid.required"=>"不正な処理です"
        ];
    }


}
