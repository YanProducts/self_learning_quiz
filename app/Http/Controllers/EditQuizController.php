<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QUiz_list;
use App\Models\Theme;
use App\Enums\QuizPtn;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EditWord_Request;
use App\Http\Requests\Create_Request;

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
            "js_sets"=>["quiz/edit/search","before_play","index"],
            "li_option_sets"=>$li_option_sets
        ]);
    }

    // 該当する全てのクイズリストを返す
    public function view_all_quiz_lists(){
       $quiz_lists=Quiz_list::all();
       return view("quiz/edit/view_edit_quiz_lists")->with([
            "quiz_lists"=>$quiz_lists,
            "js_sets"=>["quiz/edit/choise"]
       ]);
    }

    // １部の言葉が含まれるクイズを返す
    public function edit_from_word(EditWord_Request $request){

        // 検索結果のセット
        $quiz_lists=$this->search_result_sets($request->what_num+1,$request->edit_search_andor,$request);

        return view("quiz/edit/view_edit_quiz_lists")->with([
            "quiz_lists"=>$quiz_lists,
            "js_sets"=>["quiz/edit/choise"]
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
                    $query->where($search_where,"like","%${search_word}%");
                }
                else{
                    $query->orwhere("title","like","%${search_word}%");
                    $query->orwhere("quiz","like","%${search_word}%");
                    $query->where("answer","like","%${search_word}%");
                }
                if($search_where==="answer" || $search_where==="all"){
                    for($n=2;$n<=5;$n++){
                        $query->orWhere("answer".$n,"like","%${search_word}%");
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
                  throw new Exception("検索条件設定のエラーです");
                break;
            }
        }

        // 検索結果のidリストから検索結果取得
        $quiz_lists=Quiz_list::whereIn("id",$hit_lists)->get();

        // 検索結果を配列で返す
        return $quiz_lists;
    }

    // 条件に合うクイズを返す
    public function edit_from_case(){
        return redirect("quiz/edit/view_edit_quiz_lists")->with([
            "quiz_lists"=>$quiz_lists
            ]);
    }

    // 編集するクイズの決定→編集ページへ
    // post処理はimplicit binding使わない
    public function edit_decide(Request $request){

        // バリデーション
        // 返り値が未設定！！！！！！！！
        $request->validate([
            "edit_quiz_decide"=>"required|int"
        ],
        [
            "edit_quiz_decide.required"=>"選択されていません",
            "edit_quiz_decide.int"=>"入力データが不正です"
        ]);

        // idを受け取る
        $quiz_for_edit=Quiz_list::find($request->edit_quiz_decide);
        $edit_quiz_themes=[
            $quiz_for_edit["theme_name"],
            $quiz_for_edit["theme_name2"],
            $quiz_for_edit["theme_name3"],
        ];

        // 受け渡す変数の格納
        // js_setsはcreateと同じ（？）
        $valuesets=array_merge(self::setReturnsets(),["js_sets"=>[ "quiz/create"],"mode"=>"編集","quiz_for_edit"=>$quiz_for_edit,"edit_quiz_themes"=>$edit_quiz_themes
        ]);

        // 存在しなければデフォルトエラーページへ
        if(!$quiz_for_edit){
            throw new \Exception("存在しないidです");
        }else{
        // 編集本番ページ
            return view("quiz/edit/review")->with($valuesets);
      }
    }


    // バリデーションで返された場合はgetで返す必要がある
    // idで渡した初期値は「old」で変更直前の値を保持
    public function edit_decide_get(){


        // 受け渡す変数の格納
        // js_setsはcreateと同じ（？）
        $valuesets=array_merge(self::setReturnsets(),["js_sets"=>[ "quiz/create"],"mode"=>"作成","quiz_for_edit"=>""
        ]);

        // 存在しなければデフォルトエラーページへ
        // if(!$quiz_for_edit){
        //     throw new \Exception("存在しないidです");
        // }else{
        // 編集本番ページ
            return view("quiz/edit/review")->with($valuesets);
    //   }

    }


    // クイズの編集決定


    public function edit_final(Create_Request $request){
        // editの場合はidも必要
        // 返り値が未設定！！！！！！！！

        $request->validate([
            "edit_id"=>"required|int"
        ],
        [
            "edit_id.required"=>"選択されていません",
            "edit_id.int"=>"入力データが不正です"
        ]);

        // sqlデータ変更

        // dd($request->edit_id);

        
        // リダイレクト(リロード対策にviewで渡す)
        return view("test");

    }


    
    
    // クイズの消去
    public function delete_quiz(){
        
        return redirect("quiz/edit/view_edit_quiz_list")->with([
            "quiz_lists"=>$quiz_lists
        ]);
    }
}
