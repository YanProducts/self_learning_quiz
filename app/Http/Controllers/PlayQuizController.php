<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\Quiz_list;
use App\Enums\QuizPtn;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\DB;


class PlayQuizController extends Controller
{

    // 何のクイズを行うか
    public function before_play_quiz(){
         
        $valuesets=QuizController::setReturnsets();

        return view("quiz/before_play_quiz")->with($valuesets);
     }

    // クイズで遊ぶ
    public function play_quiz(Request $request){
        // バリデーション
        $request->validate([

        ]);

        $theme_what=$request->theme_what;


        // 出題するクイズの取得
        $all_quizzes=self::get_allquiz_data($request,$theme_what);


        // 出題クイズのjson用
        $base64Data = self::gzip($all_quizzes);

        // 表示用にarray分割
        list($theme_view,$theme_other,$count_other)=self::themes_for_view($theme_what);

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
            "first_quiz"=>$all_quizzes[0] ?? "no_quiz",
            "all_to_json"=>$base64Data,

            // 何問目かのフラグ
            "num"=>0,
        ]);
    }

    // 該当クイズSQLの取得(play_quizの一部)
    public function get_allquiz_data($request,$theme_what){

          $query=Quiz_List::where([
                ["level",">=",intval($request->level_min)],
                ["level","<=",intval($request->level_max)],
                ["ptn","=",$request->answer_which]
           ])
           ->whereBetween(
                DB::raw("(correct/(correct + wrong)) *100"),
                [intval($request->percent_min),intval($request->percent_max)]
             );

        
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
        // バリデーション
        try{
          $request->validate([
                "isok"=>"regex:/^(ok|out)$/"
            ]);
        }catch(\ValidationException $e){
            return response()->json(["result_plus"=>"error"]);
        }

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
        return response()->noContent();
  
    }

}
