<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NotInExistTheme;
use App\Rules\InExistKind;
use App\Rules\NotInExistKind;
use App\Rules\NotRegexComma;
use App\Rules\NotRegexAllThemes;

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
        $route_name=request()->route()->getName();
        $choise_new_ptn=request()->input("select_first_choise");
        $choise_edit_ptn=request()->input("select_second_choise");

        $rules=[];
        if($route_name==="create_theme_route"){
            $rules=array_merge($rules,[
                "new_theme_name"=>[
                    "required",
                    "min:3",
                     new NotRegexComma,
                     new NotRegexAllThemes,
                     new NotInExistTheme
                ],
                "select_first_choise"=>[
                    "regex:/^(nothing|new|exist)$/"
                ]
            ]);
            if($choise_new_ptn==="exist"){
               $rules=array_merge($rules,[
                "exist_kinds_select"=>[
                    "required",
                    new InExistKind
                    ]
                ]);
            }
            else if($choise_new_ptn==="new"){
                $rules=array_merge($rules,[
                "new_kind_name"=>[
                    "required",
                    "min:3",
                    new NotRegexComma,
                    new NotRegexAllThemes,
                    new NotInExistKind
                  ]
             ]);
            }
        }else if($route_name==="edit_theme_route"){
            // 小テーマ変更
            if($choise_edit_ptn==="theme"){
                 $rules=array_merge($rules,[
                        // 新しい名前
                        "edit_theme_name"=>[
                        "required",
                        "min:3",
                        new NotRegexComma,
                        new NotRegexAllThemes,
                        new NotInExistTheme
                        ],
                        // 以前のid
                        "old_theme_id"=>[
                            "required",
                            "regex:/^[0-9]+$/"
                        ]
                    ]);
                }
                // 大テーマ変更
                else if($choise_edit_ptn==="kind"){
                    $rules=array_merge($rules,[
                        // 大テーマの名前
                        "edit_kind_name"=>[
                        "required",
                        "min:3",
                        new NotRegexComma,
                        new NotRegexAllThemes,
                        new NotInExistKind
                        ],
                        // 名称はidだが実際は文字
                        "old_kind_id"=>
                        [
                         "required",
                         new InExistKind
                        ]
                        ]);
                }else{
                // 不正な処理
                $rules=array_merge($rules,[
                    // 存在しない値を設定
                    "is_valid"=>"required"
                 ]);
                }
        }else{
            // 不正な処理
            $rules=array_merge($rules,[
                // 存在しない値を設定
                "is_valid"=>"required"
            ]);
        }
        return $rules;
    }
    public function messages(){
        return[
            "new_theme_name.required"=>"テーマは入力必須です",
            "new_theme_name.min"=>"テーマは３文字以上で記入してください",
            "select_first_choise.not_regex"=>"種類選択のエラーです",
            "exist_kinds_select.required"=>"大テーマが選択されていません",
            "new_kind_name.required"=>"大テーマが記入されていません",
            "new_kind_name.min"=>"大テーマは３文字以上で記入してください",
            "old_theme_id.required"=>"以前の小テーマが見つかりません",
            "old_theme_id.regex"=>"以前の小テーマが見つかりません",
            "edit_theme_name.required"=>"入力必須です",
            "old_kind_id.required"=>"以前の大テーマが見つかりません",
            "edit_kind_name.required"=>"入力必須です",
            "is_valid.required"=>"不正な処理です"
        ];
    }
}
