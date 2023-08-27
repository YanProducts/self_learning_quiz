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
              return redirect()->route("creteroute");
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
}
