<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SignController extends Controller
{
    // お知らせの画面表示
    public function view_sign(){
        if(!session()->has("naiyou") || !session()->has("pageRoute")){
            return redirect()->route("indexroute");
        }else{
            return view("sign");
        }        
    }
}
