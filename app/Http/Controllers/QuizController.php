<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QUiz_list;
use App\Models\Theme;
use App\Enums\QuizPtn;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function setReturnsets(){
       return
       [
        "quiz_lists"=>Quiz_list::all(),
        "theme_lists"=>Theme::orderBy("kind")->get(),
        "ptn_which"=>QuizPtn::getDescriptions(),
        "default_kind"=>""
       ];
    }
    
    


    // 何のクイズを行うか
    public function before_play_quiz(){
       return view("quiz/before_play_quiz");
    }
    
    // クイズの作成
    public function create_quiz(){
        return view("quiz/create")
        ->with($this->setReturnsets());
    }

    // クイズの作成->投稿
    public function post_create_quiz(Request $request){

        // ここでhtmlspecialcharsエスケープいらないの？？？
        $request->validate(
            [
                "title"=>"required",
                "quiz"=>"required|min:3",
                "answer"=>"required|min:1",
                "level"=>"required|integer"
            ],
            [
                "title.required"=>"タイトルが入力されていません",
                "quiz.required"=>"クイズが入力されていません",
                "answer.required"=>"回答が入力されていません",
                "level.required"=>"レベルが入力されていません",
                "quiz.min"=>"クイズが短すぎます",
                "answer.min"=>"回答が短すぎます",
                "level.integer"=>"レベルは数値で記入してください",
            ]
        );

        // 登録
        try{

            DB::transaction(function()use($request){
                $quiz=new Quiz_list;
                $quiz->title=$request->title;
                $quiz->quiz=$request->quiz;
                $quiz->answer=$request->answer;
    
                // この部分はバリデーション設定
                $quiz->answer2=$request->answer2;
                $quiz->answer3=$request->answer3;
                $quiz->answer4=$request->answer4;
                $quiz->answer5=$request->answer5;
                $quiz->theme_name=$request->theme;
                $quiz->level=$request->level;
                $quiz->ptn=$request->ptn;
                $quiz->save();
    
            });
        }catch(\PDOException $e){
            $naiyou="エラーです\n".$e->getMessage();
            $page="createroute";

            return view("sign",["naiyou"=>$naiyou,"pageRoute"=>$page]);
        }
        $naiyou="登録完了しました！";
        $page="createroute";

        return view("sign",["naiyou"=>$naiyou,"pageRoute"=>$page]);
    }
    
    // クイズの編集
    public function edit_quiz(){
        return view("quiz/edit");
    }

    // クイズの消去
    public function delete_quiz(){

    }
}
