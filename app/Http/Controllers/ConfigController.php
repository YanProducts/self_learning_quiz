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

        $theme_lists=Theme::pluck("theme_name");
        $kind_lists=Theme::groupby("kind")->pluck("kind");

       return view("config")->with(["theme_lists"=>$theme_lists,
       "kind_lists"=>$kind_lists,"js_sets"=>["config"]]);
    }

    // 作成ルート
    public function create_theme(Theme_Request $request){
        $theme_name=$request->new_theme_name;
        try{
            DB::transaction(function()use ($theme_name){
                // 重複確認
                $this->is_multiple($theme_name);     
                
                // 登録
                $themes=new Theme;
                $themes->theme_name=$theme_name;
                $themes->save();
            });
        }catch(\Throwable $e){
            return redirect()->route("configroute")->with(["Error"=>$e->getMessage()]);
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


    public function is_multiple($theme_name){
        // 重複除去
        $all_themes=Theme::pluck("theme_name")->toArray();
        if(in_array($theme_name,$all_themes)){
            throw new CustomException("既に登録されています");
        }        
    }


}
