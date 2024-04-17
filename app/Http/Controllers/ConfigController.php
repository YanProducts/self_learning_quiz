<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Theme;
use App\Models\Quiz_list;
use App\Http\Requests\ThemeRequest;
use App\Exceptions\CustomException;

class ConfigController extends Controller
{
    // configのトップ画面
    public function config_theme(){
        // 第１条件は「テーマなし」を最後に、他はkindの順で
        $all_lists = Theme::orderByRaw("CASE WHEN kind = 'テーマなし' THEN 1 ELSE 0 END, kind")->get();

        $theme_lists=Theme::pluck("theme_name");

        $kind_lists=Theme::groupby("kind")->orderByRaw("CASE WHEN kind = 'テーマなし' THEN 1 ELSE 0 END, kind")->pluck("kind");

       return view("config.config")->with(["theme_lists"=>$theme_lists,
       "kind_lists"=>$kind_lists,
       "all_lists"=>$all_lists,
       "js_sets"=>["config","index","validationReturn"]]);
    }

    // 作成ルート
    public function create_theme(ThemeRequest $request){
        $theme_name=$request->new_theme_name;

        try{
            DB::transaction(function()use ($theme_name,$request){
                // 登録(重複確認はバリデーションで行っている)
                $themes=new Theme;
                $themes->theme_name=$theme_name;
                $themes->kind=
                $request->select_first_choice==="new" ? $request->new_kind_name : ($request->select_first_choice==="exist" ? $request->exist_kinds_select : "テーマなし");
                $themes->save();
            });
        }catch(\Throwable $e){
            throw new CustomException("テーマ登録時のエラーです");
        }
        return redirect()->route("configroute")->with(["message"=>"テーマを登録しました！"]);
    }

    // 編集ページ表示
    public function edit_theme(ThemeRequest $request){

        // 小テーマか大テーマか
        // themeかkind以外はrequestの例外除去で弾いている
        // kindのold_idは文字だが、コードの簡素化のためidで統一
        $which=$request->select_second_choice;
        $old_id=$which === "theme" ? $request->old_theme_id : ($which==="kind" ? $request->old_kind_id : "既に除去");
        $new_name=$which === "theme" ? $request->edit_theme_name : ($which==="kind" ? $request->edit_kind_name :"既に除去");


        try{
            DB::transaction(function()use($which,$old_id,$new_name){
                // データ変更
                if($which==="theme"){
                    $this->change_theme_name($old_id,$new_name);
                }else if($which==="kind"){
                    // old_idは実際は文字
                    $this->change_kind_name($old_id,$new_name);
                }else{
                    throw new CustomException("invalid_theme");
                }
            });
        }catch(\Throwable $e){
            throw new CustomException($e->getMessage()==="invalid_theme" ? "不正なテーマ選択です" : "テーマ消去時のエラーです");
        }
        return redirect()->route("configroute")->with(["message"=>"テーマを編集しました！"]);
    }


    // 小テーマ変更
    public function change_theme_name($old_id,$new_name){
        // 既にトランザクション内部
        $change_data= Theme::where("id","=",$old_id)->first();
        if($change_data!==null){
            $change_data->theme_name=$new_name;
            $change_data->save();
        }else{
            throw new \PDOException("元データが見当たりません");
        }
    }


    // 大テーマ変更
    // 実引数のold_idは文字のため、ここではold_nameに変更
    public function change_kind_name($old_name,$new_name){
        // 既にトランザクション内部
        $change_data=Theme::where("kind","=",$old_name)->get();
        if(!empty($change_data)){
            foreach($change_data as $c){
                $c->kind=$new_name;
                $c->save();
            }
        }else{
            throw new \PDOException("元データが見当たりません");
        }
    }

    // 小テーマの大テーマ移動
    public function move_theme(ThemeRequest $request){

        try{
            DB::transaction(function()use($request){
                // 移動前ID(既にexistかどうかは弾いている)
                $move_quiz=Theme::find($request->move_before_theme_id);
                // 移動先(newとexist以外は既に弾いている)
                $move_quiz->kind=$request->select_third_choice==="new" ? $request->move_new_input : ($request->select_third_choice==="exist" ? $request->move_before_kind:"既に除去");
                $move_quiz->save();
            });
        }catch(\Throwable $e){
            throw new CustomException("テーマ移動時のエラーです");
        }

        return redirect()->route("configroute")->with(["message"=>"大テーマを移動しました！"]);

    }

    // テーマの削除
    public function delete_theme(ThemeRequest $request){

        // 小テーマが含まれるクイズがあればどうするか？
        if($request->select_fourth_choice==="theme"){
            $id=$request->delete_theme_id;
            $delete_theme_name=Theme::find($id)->theme_name;
            // 戻り値がnullでなければ含まれていたら確認ページへ移動
            $mustFixdAnothePlaceQuiz=$this->quizInDeleteTheme_process($delete_theme_name);
            $all_themes=Theme::orderby("kind")->get();
            if(!empty($mustFixdAnothePlaceQuiz)){
              session([
                "all_themes"=>$all_themes,
                "exist_quizzes"=>$mustFixdAnothePlaceQuiz,
                "delete_theme_name"=>$delete_theme_name,
                "delete_theme_id"=>$id,
                "js_sets"=>["config","index","validationReturn"]
              ]);
              return redirect()->route("fixQuiz_when_deleteTheme_route");
            };
        }

       // 編集するテーマがどちらか
        $which="";

        try{
         DB::transaction(function()use($request, &$which){
              // 大テーマ削除＝大テーマを「大テーマなし」に変更
              if($request->select_fourth_choice==="kind"){
                $delete_kind_lists=Theme::where("kind","=",$request->delete_kind)->get();
                foreach($delete_kind_lists as $delete_kind_list){
                    $delete_kind_list->kind="テーマなし";
                    $delete_kind_list->save();
                }
                $which="大テーマ";
              // 小テーマを消去
              }else if($request->select_fourth_choice==="theme"){
                $delete_theme=Theme::find($request->delete_theme_id);
                $delete_theme->delete();
                $which="小テーマ";
              }else{
                //ここではcatchにまず投げる
                throw new CustomException("invalid_theme");
              }
            });
        } catch (\Throwable $e) {
            throw new CustomException($e->getMessage()==="invalid_theme" ? "不正なテーマ選択です" : "テーマ消去時のエラーです");
        }
        return redirect()->route("configroute")->with(["message"=>$which."を削除しました！"]);
    }

    // クイズに削除したい唯一のテーマが含まれる時のビュー
    public function fixQuiz_when_deleteTheme_view(){

        // session確認
        if(!session()->has("all_themes") || !session()->has("exist_quizzes") || !session()->has("delete_theme_name") || !session()->has("delete_theme_id") || !session()->has("js_sets")){
             throw new CustomException("不正なアクセスです");
        }

        // sessionから変数へ
            $all_themes=session("all_themes");
            $exist_quizzes=session("exist_quizzes");
            $delete_theme_name=session("delete_theme_name");
            $delete_theme_id=session("delete_theme_id");
            $js_sets=session("js_sets");

            // セッションデータを消去するとvalidationの時に問題なので消去しない

            return view("config/pages/fixQuiz_when_deleteTheme_confirm")->with([
                "all_themes"=>$all_themes,
                "exist_quizzes"=>$exist_quizzes,
                "delete_theme_name"=>$delete_theme_name,
                "delete_theme_id"=>$delete_theme_id,
                "js_sets"=>$js_sets
            ]);
    }


    // 小テーマの削除候補にクイズが既に入っているかどうか
    public function quizInDeleteTheme_process($delete_theme){
        try{
           $result=DB::transaction(function()use($delete_theme){
                // 該当テーマが入っているクイズを返す
                $exist_quizzes=Quiz_list::where("theme_name","=",$delete_theme)->orWhere("theme_name2","=",$delete_theme)->orWhere("theme_name3","=",$delete_theme)->get();

                // emptyならnullを返す
                if($exist_quizzes->isEmpty()){
                    return null;
                }

                // 修正が必要なクイズリスト
                $mustFixdAnothePlaceQuiz=[];

                // 該当テーマが複数あるものかどうかで処理を分ける。テーマを複数もつものは、テーマをスライドする
                // mustFixedAnotherPlaceは参照渡し
                $this->themeDeleteInQuiz_fix_process($exist_quizzes,$delete_theme,$mustFixdAnothePlaceQuiz);

                // テーマがクイズに入っている結果を返す
                // dd($mustFixdAnothePlaceQuiz);
                return $mustFixdAnothePlaceQuiz;
            });
         return $result;
            }catch(\Throwable $e){
            //    throw new CustomException("小テーマ検索時のエラーです");
               throw new CustomException($e->getMessage());
           }
    }

    // 消去予定テーマがどの番号のテーマに含まれているクイズの場合分けする
    private function themeDeleteInQuiz_fix_process($exist_quizzes,$delete_theme,&$mustFixdAnothePlaceQuiz){

        foreach($exist_quizzes as $quiz){
            // テーマ3が存在する時
            if(!empty($quiz->theme_name3)){
                // テーマ3が該当テーマ＝テーマ削除
                if($quiz->theme_name3===$delete_theme){
                    $quiz->theme_name3=null;
                    $quiz->save();
                }else if($quiz->theme_name2===$delete_theme){
                // テーマ2が該当テーマ＝テーマ3があればテーマ3をスライド、なければ削除
                    $quiz->theme_name2=$quiz->theme_name3;
                    $quiz->theme_name3=null;
                    $quiz->save();
                }else{
                // テーマ1が該当テーマ＝テーマ3,2をそれぞれスライド
                    $quiz->theme_name=$quiz->theme_name2;
                    $quiz->theme_name2=$quiz->theme_name3;
                    $quiz->theme_name3=null;
                    $quiz->save();
                }
            // テーマ3が存在せずテーマ2がある場合
            }else if(!empty($quiz->theme_name2)){
                if($quiz->theme_name2===$delete_theme){
                    // テーマ2が該当テーマ＝削除
                    $quiz->theme_name2=null;
                    $quiz->save();
                }else{
                    // テーマ1が該当テーマ＝スライド
                    $quiz->theme_name=$quiz->theme_name2;
                    $quiz->theme_name2=null;
                    $quiz->save();
                }
            // テーマ1のみ存在で、かつ該当テーマ=リストに追加
            }else{
                array_push($mustFixdAnothePlaceQuiz,$quiz);
            }
        }

    }

    // テーマ削除の際に該当テーマがその１つしかないクイズをどうするか(決定して操作)
    public function quizProcess_when_deleteOnlyTheme(ThemeRequest $request){

        try{
            $process_name=DB::transaction(function()use($request){

            // テーマの名前の取得...戻り値は処理の名前
            $delete_theme_name=Theme::find($request->delete_theme_id)->theme_name;
            $process=$request->select_first_choice;
            switch($process){
                // 新しいテーマ作成
                case "create":
                    //inputの値の取得
                     $new_theme_name=$request->new_input_when_delete;
                    //  テーマに追加
                     $new_theme=new Theme;
                     $new_theme->theme_name=$new_theme_name;
                     $new_theme->kind="テーマなし";
                     $new_theme->save();
                    // クイズのテーマの編集
                     Quiz_list::where("theme_name","=",$delete_theme_name)->update(["theme_name"=>$new_theme_name]);
                break;
                // 既存テーマに変更
                case "change":
                    $new_theme_id=$request->exist_select_when_delete;
                    $new_theme_name=Theme::find($new_theme_id)->theme_name;
                    Quiz_list::where("theme_name","=",$delete_theme_name)->update(["theme_name"=>$new_theme_name]);
                break;
                // 該当テーマ設定時のクイズ削除
                case "delete":
                    // クイズの削除
                    // その時点では、クイズテーマは既にスライド済
                    Quiz_list::where("theme_name","=",$delete_theme_name)->delete();
                break;
                default:
                throw new CustomException("invalid");
            }
            // テーマの削除
            Theme::where("theme_name","=",$delete_theme_name)->delete();
            return $process;
          });
        }catch(\Throwable $e){
            throw new CustomException($e->getMessage() ===  "invalid" ? "不正な処理です" : "小テーマ設定クイズの\n操作時のエラーです");
        }
        // sessionの削除
        session()->forget("all_themes");
        session()->forget("exits_quizzes");
        session()->forget("delete_theme_name");
        session()->forget("delete_theme_id");
        session()->forget("js_sets");



        // メッセージ
        $message=($process_name==="create" || $process_name==="change") ? "該当クイズのテーマを変更し\nテーマを削除しました" : "テーマとテーマを含むクイズを削除しました";

        return redirect()->route("configroute")->with(["message"=>$message]);

    }


}
