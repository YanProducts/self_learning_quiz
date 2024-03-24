<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\Quiz_list;
use App\Enums\QuizPtn;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BeforePlay_Request;


class PlayQuizController extends Controller
{

    // 何のクイズを行うか
    public function before_play_quiz(){
        // まだ１つもクイズがない場合
        if(!Quiz_list::exists()){
            return redirect()->route("indexroute")->with([
                "firstStepMessage"=>"クイズが１つもありません"
            ]);
        }

        $valuesets=QuizController::setReturnsets();
        $valuesets["js_sets"]=["quiz/before_play"];

        return view("quiz/before_play_quiz")->with($valuesets);
     }

    // クイズで遊ぶ
    public function play_quiz(BeforePlay_Request $request){

        $theme_what=$request->theme_what;

        // 出題するクイズの取得
        $all_quizzes=self::get_allquiz_data($request,$theme_what);

        // 出題クイズのjson用
        $base64Data = self::gzip($all_quizzes);

        // 表示用にarray分割
        list($theme_view,$theme_other,$count_other)=self::themes_for_view($theme_what);

        // 最初の問題の表示用
        if(isset($all_quizzes[0])){
            $first_quiz=$all_quizzes[0];
            // テーマ表示の変換

            if(!empty($first_quiz["theme_name"])){
                $first_quiz["displaytheme"]=$first_quiz["theme_name"];
                if(!empty($first_quiz["theme_name2"])){
                    $first_quiz["displaytheme"]=$first_quiz["displaytheme"]." ".$first_quiz["theme_name2"];
                    if(!empty($first_quiz["theme_name3"])){
                        $first_quiz["displaytheme"]=$first_quiz["displaytheme"]."、".$first_quiz["theme_name3"];
                    }
                }
            }
            // 正解率表示の転換
            if($first_quiz["correct"]+$first_quiz["wrong"]===0){
                $first_quiz["percent"]=0;
            }else{
                $first_quiz["percent"]=round(($first_quiz["correct"]/($first_quiz["correct"]+$first_quiz["wrong"]))*100,1);
            }
        }else{
            $first_quiz="no_quiz";
        }


        // ページへ
        return view("quiz/play_quiz")->with([
            "theme_view"=>$theme_view,
            "theme_other"=>$theme_other ?? "",
            "count_other"=>$count_other,
            "ptn"=>$request->answer_which,
            "min_level"=>$request->level_min,
            "max_level"=>$request->level_max,
            "min_percent"=>$request->percent_min,
            "max_percent"=>$request->percent_max,
            "first_quiz"=>$first_quiz,
            "all_to_json"=>$base64Data,
            "quiz_sum_count"=>count($all_quizzes),
            // 何問目かのフラグ
            "num"=>0,
            "js_sets"=>["quiz/play"]
        ]);
    }

    // 該当クイズSQLの取得(play_quizの一部)
    public function get_allquiz_data($request,$theme_what){

        // ベース部分
          $query=Quiz_List::where([
                ["level",">=",intval($request->level_min)],
                ["level","<=",intval($request->level_max)],
                ["ptn","=",$request->answer_which]
           ]);

        // 正解率
        if(intval($request->percent_min)===0){
          $query
          ->where(function($q)use($request){
        //  最低が０％＝未回答クイズも出題
                $q->where(DB::raw("correct + wrong"),"=",0)
                  ->orWhereBetween(
                    DB::raw("(correct/(correct + wrong)) *100"),
                    [intval($request->percent_min),intval($request->percent_max)]
                  );
            });
        }else{
            $query
            ->where(function($q)use($request){
                $q
                  ->where(DB::raw("correct + wrong"),">",0)
                  ->whereBetween(
                    DB::raw("(correct/(correct + wrong)) *100"),
                    [intval($request->percent_min),intval($request->percent_max)]
                 );
            });
        }


            // all_themes以外は下記で絞る(all_themesが入っていたら全部選ぶから絞らない)
            if(!in_array("all_themes",$theme_what)){
                $query
                ->where(function($q) use($theme_what){
                    $q->whereIn("theme_name",$theme_what)
                    ->orWhereIn("theme_name2",$theme_what)
                    ->orWhereIn("theme_name3",$theme_what);
                });
            }

        // 全テーマ取得がどうかで変更
            return $query->get();
    }

    // 配列→json→圧縮
    public function gzip($all_quizzes){
        $jsonString=json_encode($all_quizzes);
        $compressedData = gzencode($jsonString, 9);
        return base64_encode($compressedData);
    }

    // 表示用のテーマ取得
    public function themes_for_view($theme_what){

        // 全種類の変換
        for($n=0;$n<count($theme_what);$n++){
            if(mb_strpos($theme_what[$n],"all_themes")>-1){
                if($theme_what[$n]==="all_themes"){
                    // 全テーマ全種類の場合
                    // 表示用のtheme_whatは「全種類」のみ
                    $theme_what=["全種類"];
                }else{
                    // 〜の全種類系列は各要素が取得されているので削除
                    unset($theme_what[$n]);
                }
            }
        }

        // ３つ以上テーマがある場合
        if(count($theme_what)>3){
            $theme_first=array_slice($theme_what,0,3);
            $theme_second=array_slice($theme_what,3);
            $theme_view=implode("、",$theme_first);
            $theme_other=implode("\n",$theme_second);
            $count_other=count($theme_second);
        }else{
            $theme_view=implode("、",$theme_what);
            $theme_other="";
            $count_other=0;
        }
        return [$theme_view,$theme_other,$count_other];
    }


    // 正解と不正解を登録
    public function to_record(Request $request){

        // バリデーション(１行のみでmessageも返さないため、登録しない)
        $request->validate([
            "is_ok"=>["required","regex:/^(ok|out)$/"]
            ]);

        try{
              DB::transaction(function() use($request){
                $plus_data=Quiz_list::find($request->quiz_id);
                if($request->is_ok==="ok"){
                    $plus_data->correct=$plus_data->correct+1;
                }else if($request->is_ok==="out"){
                    $plus_data->wrong=$plus_data->wrong+1;
                }else{
                    throw new \PDOException("正解不正解が取得できません");
                }
                $plus_data->save();
            });
        }catch(\PDOException $e){
            return response()->json(["result_plus"=>"error"]);
        }
        return response()->json([
            "ok"=>"ok"
        ]);
    }

}
