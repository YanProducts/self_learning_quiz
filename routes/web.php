<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChoiseController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\PlayQuizController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// 最初の画面
Route::get('/',[ChoiseController::class,"first_index"])
->name("indexroute");

// 何をするかの選択時
Route::post('/firstchoise',[ChoiseController::class,"firstchoise"]
)->name("firstroute");

// クイズを作る
Route::get('/createquiz',[QuizController::class,"create_quiz"]
)->name("createroute");

// クイズを編集する
Route::get('/editquiz',[QuizController::class,"edit_quiz"]
)->name("editroute");

// テーマの設定ページへ
Route::get('/configquiz',[ConfigController::class,"config_theme"]
)->name("configroute");

// テーマ作成
Route::post("/configquiz/create",[ConfigController::class,"create_theme"])
->name("create_theme_route");

// テーマ編集
Route::patch("/configquiz/edit",[ConfigController::class,"edit_theme"])
->name("edit_theme_route");

// クイズ作成→投稿
Route::post("/post_createquiz",[QuizController::class,"post_create_quiz"])
->name("post_create_route");

// クイズで遊ぶカテゴリー選び
Route::get('quiz/beforequiz',[PlayQuizController::class,"before_play_quiz"]
)->name("before_quiz_route");

// 選んでからクイズで遊ぶページへ
Route::post("quiz/playquiz",[PlayQuizController::class,"play_quiz"])
->name("play_quiz_route");

// 結果を登録
Route::post("quiz/check",[PlayQuizController::class,"to_record"])
->name("to_record_route");

// 編集するクイズリストの表示
Route::get("quiz/edit/view_all_quiz_list",[QuizController::class,"view_all_quiz_lists"])
->name("edit_from_all_route");

// 言葉から該当するクイズの取得
Route::post("quiz/edit/from_words",[QuizController::class,"edit_from_words"])
->name("edit_from_words_route");

// 条件から該当するクイズの取得（編集用）
Route::post("quiz/edit/from_case",[QuizController::class,"edit_from_case"])
->name("edit_from_case_route");

// 編集クイズ決定→編集ページ
Route::post("quiz/edit/edit_decide",[QuizController::class,"edit_decide"])
->name("edit_decide_route");



// お知らせのページ
// Route::get("sign{naiyou}{page}{js_needless}",[ChoiseController::class,"view_sign"])
// ->name("sign_route");