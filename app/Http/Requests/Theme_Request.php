<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\InExistThemeId;
use App\Rules\NotInExistTheme;
use App\Rules\InExistKind;
use App\Rules\NotInExistKind;
use App\Rules\NotRegexComma;
use App\Rules\NotRegexAllThemes;
use App\Rules\NotRegexNoThemeInJp;

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
        $choise_move_ptn=request()->input("select_third_choise");

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
                    new NotRegexNoThemeInJp,
                    new NotInExistKind
                  ]
             ]);
            }
        }else if($route_name==="edit_theme_route"){
            // 小テーマ変更
            if($choise_edit_ptn==="theme"){
                 $rules=[
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
                            new InExistThemeId
                        ]
                    ];
                }
                // 大テーマ変更
            else if($choise_edit_ptn==="kind"){
                    $rules=[
                        // 大テーマの名前
                        "edit_kind_name"=>[
                        "required",
                        "min:3",
                        new NotRegexComma,
                        new NotRegexAllThemes,
                        new NotRegexNoThemeInJp,
                        new NotInExistKind,
                        ],
                        // 名称はidだが実際は文字
                        "old_kind_id"=>
                        [
                         "required",
                         new InExistKind
                        ]
                    ];
                }else{
                // 不正な処理
                $rules=[
                    // 存在しない値を設定
                    "is_valid"=>"required"
                 ];
                }
        // 大テーマを移動
        }else if($route_name==="move_theme_route"){
            $rules=[
                "move_before_theme_id"=>[
                    "required",
                    "integer",
                    new InExistThemeId             
                ]
            ];
            if($choise_move_ptn==="new"){
                $rules=array_merge($rules,[
                    "move_new_input"=>[
                        "required",
                        "string",
                        new NotRegexComma,
                        new NotRegexAllThemes,
                        new NotRegexNoThemeInJp,
                    ]
                ]);
            }else if($choise_move_ptn==="exist"){
                $rules=array_merge($rules,[
                    "move_before_kind"=>[
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

            // create
            "new_theme_name.required"=>"テーマは入力必須です",
            "new_theme_name.min"=>"テーマは３文字以上で記入してください",
            "select_first_choise.not_regex"=>"種類選択のエラーです",
            "exist_kinds_select.required"=>"大テーマが選択されていません",
            "new_kind_name.required"=>"大テーマが記入されていません",
            "new_kind_name.min"=>"大テーマは３文字以上で記入してください",

            // edit
            "edit_theme_name.required"=>"入力必須です",
            "edit_theme_name.min"=>"テーマは3文字以上です",
            "old_theme_id.required"=>"以前の小テーマが見つかりません",
            "edit_kind_name.required"=>"入力必須です",
            "edit_kind_name.min"=>"大テーマは３文字以上で記入してください",
            "old_kind_id.required"=>"以前の大テーマが見つかりません",
            
            // move
            "move_before_theme_id.required"=>"以前のテーマを選択してください",
            "move_before_theme_id.integer"=>"以前のテーマ選択のエラーです",
            "move_new_input.required"=>"大テーマの移動先が未入力です",
            "move_new_input.min"=>"大テーマは3文字以上で記入してください",
            "move_before_kind.id"=>"テーマの移動先が入力できていません",

            // delete


            "is_valid.required"=>"不正な処理です"
        ];
    }
}
