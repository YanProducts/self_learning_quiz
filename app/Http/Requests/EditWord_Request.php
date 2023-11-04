<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditWord_Request extends FormRequest
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
        $rule=[
            "what_num"=>"required|integer",
            "edit_search_andor"=>"required|in:normal,type_a,type_o"
        ];
        $count=$this->what_num;
        for($num=0;$num<$count;$num++){
            $rule["search_where".$num]="required|in:title,quiz,answer,all";
            $rule["search_word".$num]="required";
        }
        return $rule;
    }

    public function messages(){
        $message=[
            "what_num.required"=>"設定上のエラーです",
            "what_num.integer"=>"設定上のエラーです",
            "edit_search_andor.required"=>"設定上のエラーです",
            "edit_search_andor.in"=>"設定上のエラーです",
        ];
        $count=$this->what_num;
        for($num=0;$num<$count;$num++){
            $message["search_where".$num."reuired"]="検索条件が入力されていません";
            $message["search_where".$num."in"]="検索する言葉が未入力です";
            $message["search_word".$num."requred"]="検索条件が不正確です";
        }
        return $message;
    }
}
