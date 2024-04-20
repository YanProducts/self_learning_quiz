<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use App\Http\Controllers\QuizController;

class ChoiceController extends Controller
{

    // 初期ページの表示
    public function first_index(){

        // 実行の中で設定したsessionを消去
        $this->clear_all_set_sessions();

        $values=[
            "li_option_sets"=>[
                "play"=>"クイズを行う",
                "make"=>"クイズを作る",
                "edit"=>"クイズを編集/削除する",
                "config"=>"テーマを編集する"
            ],
            "js_sets"=>["index"]
        ];

        return view('index')->with($values);
    }



    // 初期ページの投稿
    public function firstchoice(Request $request){
        switch($request->select_first_choice){
            case "play":
              return redirect()->route("before_quiz_route");
            break;
            case "make":
              return redirect()->route("createroute");
            break;
            case "edit":
                return redirect()->route("editroute");
            break;
            case "config":
                return redirect()->route("configroute");
            break;
            default:
            //  エラーページ
            throw new CustomException("不正なルートです");
            break;
        }
    }

    // トップページ段階で操作途中のまま残っているsessionがあれば削除する
    public function clear_all_set_sessions(){
        $session_names=[
            "all_themes",
            "exits_quizzes",
            "delete_theme_name",
            "delete_theme_id",
            "js_sets",
            "onetime_editquiz_forbackList",

        ];
        foreach($session_names as $session_name){
            if(session()->has($session_name)){
                session()->forget($session_name);
            }
        }
    }


}
