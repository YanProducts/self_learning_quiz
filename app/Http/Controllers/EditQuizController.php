<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz_list;
use App\Models\Theme;
use App\Enums\QuizPtn;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EditWordRequest;
use App\Http\Requests\EditQUizRequest;
use App\Http\Requests\CreateRequest;
use App\Http\Requests\BeforePlayRequest;
use App\Exceptions\CustomException;
use Exception;

class EditQuizController extends Controller
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
            "js_sets"=>["quiz/edit/search","quiz/before_play","index"],
            "li_option_sets"=>$li_option_sets
        ]);
    }

    // 該当する全てのクイズリストを返す
    public function view_all_quiz_lists(){
       $quiz_lists=Quiz_list::all();
       return view("quiz/edit/view_edit_quiz_lists")->with([
            "quiz_lists"=>$quiz_lists,
            "js_sets"=>["quiz/edit/choice"]
       ]);
    }

    // １部の言葉が含まれるクイズを返す
    public function edit_from_word(EditWordRequest $request){

        // 検索結果のセット
        $quiz_lists=$this->search_result_sets($request->what_num+1,$request->edit_search_andor,$request);

        // バリデーションリターン後に表示するため、上記の結果をセッションで保管
      session(["onetime_editquiz_forbackList"=>$quiz_lists]);

        return view("quiz/edit/view_edit_quiz_lists")->with([
            "quiz_lists"=>$quiz_lists,
            "js_sets"=>["quiz/edit/choice"]
       ]);
     }

    // １部の言葉が含まれるクイズを返す(バリデーションリターン用にget作成)
    public function edit_from_word_get(){

        if(empty(session("onetime_editquiz_forbackList"))){
            throw new CustomException("不正なアクセスです");
        }

        // 検索結果のセット
        $quiz_lists=session("onetime_editquiz_forbackList");

        return view("quiz/edit/view_edit_quiz_lists")->with([
            "quiz_lists"=>$quiz_lists,
            "js_sets"=>["quiz/edit/choice"]
        ]);
    }


    // 検索結果をセットにする
    public function search_result_sets($count,$search_ptn,$request){

        // 戻り値を格納
        $hit_lists=[];

        for($num=0;$num<$count;$num++){
            $where="search_where".$num;
            $word="search_words".$num;
            $search_where=$request->$where;
            $search_word=$request->$word;

            // 条件に合うid
            // selectのみなのでtransaction不要
            // serach_whereによって処理を分ける

            $hit_in_condition=Quiz_list::where(function($query) use($search_word,$search_where){
                if($search_where!=="all"){
                    $query->where($search_where,"like","%".$search_word."%");
                }
                else{
                    $query->orwhere("title","like","%".$search_word."%");
                    $query->orwhere("quiz","like","%".$search_word."%");
                    $query->where("answer","like","%".$search_word."%");
                }
                if($search_where==="answer" || $search_where==="all"){
                    for($n=2;$n<=5;$n++){
                        $query->orWhere("answer".$n,"like","%".$search_word."%");
                    }
                }
            })->pluck("id")->toArray();


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
                  throw new CustomException("検索条件設定のエラーです");
                break;
            }
        }

        // 検索結果のidリストから検索結果取得
        $quiz_lists=Quiz_list::whereIn("id",$hit_lists)->get();

        // 検索結果を配列で返す
        return $quiz_lists;
    }

    // 条件に合うクイズを返す
    public function edit_from_case(BeforePlayRequest $request){
        try{
            $quiz_lists=Quiz_list::where([
                ["ptn","=",$request->answer_which]
                ])
            ->WhereBetween(
                "level",[$request->level_min,$request->level_max]
            )->where(function($query)use($request){
                $query->WhereBetween(
                    DB::raw("(correct/(correct + wrong))*100"),
                    [$request->percent_min,$request->percent_max]
                )->orWhere(
                    DB::raw("correct + wrong"),"=",0
                );
             }
            )->where(function($query)use($request){
                $query->whereIn(
                    "theme_name",$request->theme_what
                )->orWhereIn(
                    "theme_name2",$request->theme_what
                )->orWhereIn(
                    "theme_name3",$request->theme_what
                );
            })
            ->get();
        }catch(\Throwable $e){
            throw new CustomException("クイズ条件抽出時のエラーです");
        }
        return view("quiz/edit/view_edit_quiz_lists")->with([
            "quiz_lists"=>$quiz_lists,
            "js_sets"=>["quiz/edit/choice"]
            ]);
    }

    // 編集するクイズの決定→編集ページへ
    // post処理はimplicit binding使わない
    public function edit_decide(EditQUizRequest $request){

        // 前ページでのバリデーションリターン用のsession削除(emptyでもエラー発生しない)
        session()->forget("onetime_editquiz_forbackList");

        // 該当idのクイズを受け取る
        $quiz_for_edit=Quiz_list::find($request->edit_quiz_decide);


        // テーマは順不同の配列で表示
        $edit_quiz_themes=[
            $quiz_for_edit["theme_name"],
            $quiz_for_edit["theme_name2"],
            $quiz_for_edit["theme_name3"],
        ];

        // post後のリクエストバリデーションで弾かれた時の対策
        session(["onetime_editQuiz_forbackQuiz"=>
        [
         "id"=>$request->edit_quiz_decide,
         "themes"=>$edit_quiz_themes
        ]
        ]);

        // 受け渡す変数の格納
        // js_setsはcreateと同じ（？）
        $valuesets=array_merge(self::setReturnsets(),["js_sets"=>[ "quiz/create"],"mode"=>"編集","quiz_for_edit"=>$quiz_for_edit,"edit_quiz_themes"=>$edit_quiz_themes
        ]);

        // 編集本番ページ
        return view("common/create_edit")->with($valuesets);
    }


    // バリデーションで返された場合はgetで返す必要がある
    public function edit_decide_get(){

        // 前ページでsessionが設定されていないか
        if(!session()->has("onetime_editQuiz_forbackQuiz") ||
           !array_key_exists("id",session("onetime_editQuiz_forbackQuiz"))||
           !array_key_exists("themes",session("onetime_editQuiz_forbackQuiz"))
        ){
            throw new CustomException("ルートが不正\nまたは時間切れです");
        }
        $quiz_for_edit=Quiz_list::find(session("onetime_editQuiz_forbackQuiz")["id"]);
        $edit_quiz_themes=session("onetime_editQuiz_forbackQuiz")["themes"];

        // 受け渡す変数の格納
        $valuesets=array_merge(self::setReturnsets(),[
            "js_sets"=>[ "quiz/create"],
            "mode"=>"編集",
            "quiz_for_edit"=>$quiz_for_edit,
            "edit_quiz_themes"=>$edit_quiz_themes
        ]);

        // バリデーション用のsession削除
        session()->forget("onetime_editQuiz_forbackQuiz");
        return view("common/create_edit")->with($valuesets);

    }


    // クイズの編集決定
    public function edit_final(CreateRequest $request){

        // idはcreateのrequestで処理されないため、こちらで処理
        if(!$request->edit_id || !Quiz_list::find($request->edit_id)){
            throw new CustomException("不適切な処理です");
        }else{
            $edit_quiz_set=Quiz_list::find($request->edit_id);
        }

        // バリデーション用のsession削除
        session()->forget("onetime_editQuiz_forbackQuiz");


        // theme以外のrequest
        // 後にRuleクラスで例外定義
        $requestSets=["title","quiz","answer","answer2","answer3","answer4","answer5","level","ptn"];

        // sqlデータ変更
        try{
            DB::transaction(function()use($edit_quiz_set,$request,$requestSets){
                // themne以外
                foreach($requestSets as $parameter)
                if($edit_quiz_set->$parameter!==$request->$parameter){
                    $edit_quiz_set->$parameter=$request->$parameter;
                }

                // theme
                if([$edit_quiz_set->theme_name,$edit_quiz_set->theme_name2,$edit_quiz_set->theme_name3]!==$request->themes){
                    $edit_quiz_set->theme_name=$request->themes[0];
                    $edit_quiz_set->theme_name2=$request->themes[1];
                    $edit_quiz_set->theme_name3=$request->themes[2];
                }
            $edit_quiz_set->save();
            });
        }catch(\Throwable $e){
            throw new CustomException("クイズ編集のエラーです");
        }


        $naiyou="編集完了しました！";
        $page="editroute";

        return redirect()->route("sign_route")->with(["naiyou"=>$naiyou,"pageRoute"=>$page]);

    }


    // クイズの消去
    public function delete_quiz(EditQUizRequest $request){
        try{
            DB::transaction(function()use($request){
                $delete_quiz=Quiz_list::find($request->edit_quiz_decide);
                $delete_quiz->delete();
            });
        }catch(\Throwable $e){
            return redirect(route("sign_route"))->with([
                "pageRoute"=>"editroute",
                "is_error"=>"error",
                "naiyou"=>config("app.env")==="local" ? $e->getMessage() :"削除時のエラーです"
            ]);
        }

        return redirect(route("sign_route"))->with([
            "pageRoute"=>"editroute",
            "naiyou"=>"クイズを削除しました！"
        ]);
    }
}
