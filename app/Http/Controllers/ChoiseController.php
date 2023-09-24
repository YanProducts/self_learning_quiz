<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\QuizController;

class ChoiseController extends Controller
{
    public function firstchoise(Request $request){
        switch($request->select_first_choise){
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
        // exit;
    }

    // // 完了などのサイン
    // public function view_sign($naiyou,$page,$js){
    //     return view("sign")->with([
    //         "naiyou"=>$naiyou,
    //         "pageRoute"=>$page,
    //         "js_needless"=>$js
    //     ]);
    // }


}
