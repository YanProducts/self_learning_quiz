<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\QuizController;

class ChoiceController extends Controller
{
    public function first_index(){

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
            break; 
        }
    }


}
