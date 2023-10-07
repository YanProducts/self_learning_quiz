<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;
use App\Enums\QuizPtn;
use App\Http\Controllers\QuizController;


class PlayQuizController extends Controller
{

    // 何のクイズを行うか
    public function before_play_quiz(){
         
        $valuesets=QuizController::setReturnsets();
        
        return view("quiz/before_play_quiz")->with($valuesets);
     }
}
