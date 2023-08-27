<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Theme;

class ConfigController extends Controller
{
    // configのトップ画面
    public function config_theme(){
       return view("config");
    }

    // 作成ルート
    public function create_theme(Request $request){
        $theme_name=$request->new_theme_name;
        try{
            DB::transaction(function()use ($theme_name){
                $themes=new Theme;
                $themes->theme_name=$theme_name;
                $themes->save();
            });
        }catch(\PDOException $e){
            return redirect()->route("configroute")->with(["Error"=>$e->getMessage()]);
        }
        return redirect()->route("configroute")->with(["message"=>"情報を登録しました！"]);
    }

    // 編集ページ表示
    public function edit_theme(){
       return view("config");
    }


}
