<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QUiz_list;
use App\Models\Theme;
use App\Enums\QuizPtn;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Create_Request;

class QuizController extends Controller
{
    public static function setReturnsets(){
       return
       [
        "quiz_lists"=>Quiz_list::all(),
        "theme_lists"=>Theme::orderBy("kind")->get(),
        "ptn_which"=>QuizPtn::getDescriptions(),
        "default_kind"=>""
       ];
    }
    
    
    // クイズの作成
    public function create_quiz(){
        return view("quiz/create")
        ->with(self::setReturnsets());
    }

    // クイズの作成->投稿
    public function post_create_quiz(Create_Request $request){
        
       
        // 登録
        try{

            DB::transaction(function()use($request){
                $quiz=new Quiz_list;
                $quiz->title=$request->title;
                $quiz->quiz=$request->quiz;
                $quiz->answer=$request->answer;
    
                for($n=2;$n<6;$n++){
                    $answer_num="answer".$n;
                    $quiz->$answer_num=$request->$answer_num;
                }

                $quiz->theme_name=$request->themes[0];
                
                for($n=2;$n<4;$n++){
                    if(count($request->themes)>=$n){
                        $newThemename="theme_name".$n;
                        $quiz->$newThemename=$request->themes[$n-1];
                    }
                }
                
                $quiz->level=$request->level;
                $quiz->ptn=$request->ptn;
                $quiz->save();
    
            });
        }catch(\PDOException $e){
            $naiyou="エラーです\n".$e->getMessage();
            $page="createroute";

            return view("sign",["naiyou"=>$naiyou,"is_ok"=>false,"pageRoute"=>$page]);
        }

        $naiyou="登録完了しました！";
        $page="createroute";

        return view("sign",["naiyou"=>$naiyou,"is_ok"=>true,"pageRoute"=>$page]);
    }
    
    // クイズの編集
    public function edit_quiz(){
        return view("quiz/edit");
    }

    // クイズの消去
    public function delete_quiz(){

    }
}
