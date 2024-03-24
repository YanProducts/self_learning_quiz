<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QUiz_list;
use App\Models\Theme;
use App\Enums\QuizPtn;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Create_Request;
use App\Exceptions\CustomException;

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

        $valuesets=array_merge(self::setReturnsets(),["js_sets"=>[ "quiz/create"],"mode"=>"作成"]);

        // まだテーマを設定しなければ「先にテーマを設定してください」のリンクへ
        if((!Theme::exists())){
            return redirect()->route("indexroute")->with([
                "firstStepMessage"=>"まずはテーマを設定してください"
            ]);
        }
        
        return view("common/create_edit")
        ->with($valuesets);
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

            throw new CustomException("クイズ投稿時のエラーです");

        }

        $naiyou="登録完了しました！";
        $page="createroute";

        return redirect()->route("sign_route")->with(["naiyou"=>$naiyou,"pageRoute"=>$page]);
    }

}
