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
            // throw new CustomException("テーマ登録時のエラーです");
            throw new CustomException($e->getMessage());
        }
        return redirect()->route("configroute")->with(["message"=>"テーマを登録しました！"]);
    }

    // 編集ページ表示
    public function edit_theme(Theme_Request $request){

        $old_theme_name=$request->old_theme_name;
        $new_theme_name=$request->edit_theme_name;
        try{
            DB::transaction(function()use($old_theme_name,$new_theme_name){
                // 重複確認
                $this->is_multiple($new_theme_name);
                // データ変更
                $change_data=Theme::where("theme_name","=",$old_theme_name)->first();
                if($change_data!==null){
                    $change_data->theme_name=$new_theme_name;
                    $change_data->save();
                }else{
                    throw new \PDOException("元データが見当たりません");
                }
            });
        }catch(\Throwable $e){
            return redirect()->route("configroute")->with(["Error"=>$e->getMessage()]);
        }
        return redirect()->route("configroute")->with(["message"=>"テーマを編集しました！"]);
    }




}
