<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QUiz_list;
use App\Models\Theme;
use App\Enums\QuizPtn;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Create_Request;
use App\Http\Requests\EditWord_Request;

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

        $valuesets=self::setReturnsets();

        $valuesets["js_sets"]=["quiz/create"];

        return view("quiz/create")
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

        // 全クイズの取得
        $quiz=self::setReturnsets()["quiz_lists"];
        $theme=self::setReturnsets()["theme_lists"];
        $ptn=self::setReturnsets()["ptn_which"];
        $kind=self::setReturnsets()["default_kind"];

        $li_option_sets=[
            "from_all"=>"全クイズから検索",
            "from_words"=>"問題/解答の文字から検索",
            "from_case"=>"条件から検索",
        ];


        // 表示
        return view("quiz/edit/before_edit")->with([
            "all_quizes"=>$quiz,
            "theme_lists"=>$theme,
            "ptn_which"=>$ptn,
            "js_sets"=>["quiz/edit","before_play","index"],
            "li_option_sets"=>$li_option_sets
        ]);
    }

    // 該当する全てのクイズリストを返す
    public function view_all_quiz_lists(){
       $quiz_lists=Quiz_list::all();
       return view("quiz/edit/view_edit_quiz_lists")->with([
            "quiz_lists"=>$quiz_lists,
            "js_sets"=>[]
       ]);
    }
    
    // １部の言葉が含まれるクイズを返す
    public function edit_from_word(EditWord_Request $request){
       
        // 検索結果のセット
        $quiz_lists=$this->search_result_sets($request->num,$request->edit_and_or);

        return redirect("quiz/edit/view_edit_quiz_lists")->with([
            "quiz_lists"=>$quiz_lists
            ]);
    }

    // 検索結果をセットにする
    public function search_result_sets($count,$search_ptn){

        // 戻り値を格納
        $hit_lists=[];

        for($num=0;$num<$count;$num++){
            $where="serach_where".$num;
            $word="serach_words".$num;
            $search_where=$request->$where;
            $search_word=$request->$word;

            // 条件に合うid
            $hit_in_condition=Quiz_list::where([
                $search_where,"like","%${search_word}%"
            ])
            ->pluck("id")->toArray();

            // １つ目＝配列挿入してループを抜ける
            if($num===0){
                $hit_lists=$hit_in_condition;
                continue;
            }

            // 条件に合うidリスト
            switch($search_ptn){
                // and条件
                case "type_a":
                    $hit_lists=array_intersect($hit_lists,$hit_in_condition);
                break;
                // or条件
                case "type_o":
                    $hit_lists=[...$hit_lists,...$hit_in_condition];
                    $hit_lists=array_unique($hit_lists);
                break;
                default:                
                // normalで2巡目以降がきていたらエラー
                  throw new Exception("検索条件設定のエラーです");
                break;
            }
        }

        // 検索結果のidリストから検索結果取得
        $quiz_lists=[];
        foreach($hit_lists as $h){
            $q=Quiz_list::where(["id","=",$h])->get();
            array_push($quiz_lists,$q);
        }

        // 検索結果を配列で返す
        return $quiz_lists;
    }

    // 条件に合うクイズを返す
    public function edit_from_case(){
        return redirect("quiz/edit/view_edit_quiz_lists")->with([
            "quiz_lists"=>$quiz_lists
            ]);
    }

    public function edit_decide_route(){
        
    }

    
    
    // クイズの消去
    public function delete_quiz(){
        
        return redirect("quiz/edit/view_edit_quiz_list")->with([
            "quiz_lists"=>$quiz_lists
        ]);
    }
}
