<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Theme;
use App\Http\Requests\Theme_Request;
use App\Exceptions\CustomException;

class ConfigController extends Controller
{
    // configのトップ画面
    public function config_theme(){

        $all_lists=Theme::orderBy("kind")->get();
        $theme_lists=Theme::pluck("theme_name");
        $kind_lists=Theme::groupby("kind")->pluck("kind");

       return view("config.config")->with(["theme_lists"=>$theme_lists,
       "kind_lists"=>$kind_lists,
       "all_lists"=>$all_lists,
       "js_sets"=>["config","index","validationReturn"]]);
    }

    // 作成ルート
    public function create_theme(Theme_Request $request){
        $theme_name=$request->new_theme_name;

        try{
            DB::transaction(function()use ($theme_name,$request){                
                // 登録(重複確認はバリデーションで行っている)
                $themes=new Theme;
                $themes->theme_name=$theme_name;  
                $themes->kind=
                $request->select_first_choise==="new" ? $request->new_kind_name : ($request->select_first_choise==="exist" ? $request->exist_kinds_select : "");
                $themes->save();
            });
        }catch(\Throwable $e){
            throw new CustomException("テーマ登録時のエラーです");
        }
        return redirect()->route("configroute")->with(["message"=>"テーマを登録しました！"]);
    }

    // 編集ページ表示
    public function edit_theme(Theme_Request $request){

        // 小テーマか大テーマか
        // themeかkind以外はrequestの例外除去で弾いている
        // kindのold_idは文字だが、コードの簡素化のためidで統一
        $which=$request->select_second_choise;
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
                }
  
            });
        }catch(\Throwable $e){
            throw new CustomException($e->getMessage());
            throw new CustomException("テーマ編集時のエラーです");
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
    public function move_theme(){

    }
    // テーマの削除
    public function delete_theme(){
        
    }

}
