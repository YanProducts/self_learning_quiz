<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\PlayQuizController;
use App\Http\Controllers\EditQuizController;
use App\Http\Controllers\SignController;

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
Route::get('/',[ChoiceController::class,"first_index"])
->name("indexroute");

// 何をするかの選択時
Route::post('/firstchoice',[ChoiceController::class,"firstchoice"]
)->name("firstroute");

// クイズを作る
Route::get('/createquiz',[QuizController::class,"create_quiz"]
)->name("createroute");

// クイズを編集する
Route::get('/editquiz',[EditQuizController::class,"edit_quiz"]
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

// 小テーマの大テーマ移動
Route::patch("/configquiz/move",[ConfigController::class,"move_theme"])
->name("move_theme_route");

// テーマ消去
Route::delete("/configquiz/delete",[ConfigController::class,"delete_theme"])
->name("delete_theme_route");

// 消去したいテーマを唯一のテーマに持ったクイズがある時のルート
Route::get("/configquiz/delete/fixQuiz_when_deleteTheme_confirm",
[ConfigController::class,"fixQuiz_when_deleteTheme_view"])
->name("fixQuiz_when_deleteTheme_route");

// テーマ消去...リクエストバリデーションで戻る時
Route::get("/configquiz/delete",[ConfigController::class,"delete_theme"])
->name("delete_theme_route");

// テーマ削除の際にクイズをどうするかのページのから、それを決定するフォーム
Route::patch("config/delete/quizProcessRelatedTheme",[ConfigController::class,"quizProcess_when_deleteOnlyTheme"])
->name("quizProcess_when_deleteTheme_route");


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
Route::get("quiz/edit/view_all_quiz_lists_get",[EditQuizController::class,"view_all_quiz_lists"])
->name("edit_from_all_route");


// 言葉から該当するクイズの取得
// バリデーションで返った時用にgetも用意
Route::post("quiz/edit/from_words",[EditQuizController::class,"edit_from_word"])
->name("edit_from_words_route");
Route::get("quiz/edit/from_words",[EditQuizController::class,"edit_from_word_get"])
->name("edit_from_words_get_route");


// 条件から該当するクイズの取得（編集用）
Route::post("quiz/edit/from_case",[EditQuizController::class,"edit_from_case"])
->name("edit_from_case_route");

// 編集クイズ決定→編集ページ
// バリデーションで返った時用にgetも用意
Route::post("quiz/edit/edit_decide",[EditQuizController::class,"edit_decide"])
->name("edit_decide_route");
Route::get("quiz/edit/edit_decide",[EditQuizController::class,"edit_decide_get"])
->name("edit_decide_get_route");


// 編集入力→編集決定ページ
Route::patch("quiz/edit/edit_final",[EditQuizController::class,"edit_final"])
->name("edit_final_route");

// お知らせのページ
Route::get("sign",[SignController::class,"view_sign"])
->name("sign_route");