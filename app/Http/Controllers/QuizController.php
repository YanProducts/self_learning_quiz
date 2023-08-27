<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    // 何のクイズを行うか
    public function before_play_quiz(){
       return view("quiz/before_play_quiz");
    }
    
    // クイズの作成
    public function create_quiz(){
        return view("quiz/create");
    }
    
    // クイズの編集
    public function edit_quiz(){
        return view("quiz/edit");
    }

    // クイズの消去
    public function delete_quiz(){

    }
}
