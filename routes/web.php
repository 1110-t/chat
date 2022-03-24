<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Events\PusherEvent;
use App\Http\Requests\ChatRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chat',function(){
    // 登録されているチャットをすべて取得する
    $comments = Comment::all();
    // セッションの更新
    Session::regenerate();
    // セッションにユーザー名があるか確認する
    $exist = Session::has('user');
    // あれば、そのまま変数に保存
    if($exist){
        $user = Session::get('user');
    // なければ、nullを設定する
    } else {
        $user = null;
    };
    // コメントとユーザー情報を表示する
    return view('chat',compact(['comments','user']));
});

Route::post('/chat',function(ChatRequest $request){
    // セッションの更新
    // Session::regenerate();
    // セッションにユーザー名があるか確認する
    $exist = Session::has('user');
    // あれば、そのまま変数に保存
    if($exist){
        $user = Session::get('user');
    // なければ、nullを設定する
    } else {
        $user = $request->user;
        // ユーザーをセッションに登録する
        Session::put('user', $user);
    };
    $posts = ['user' => $user, 'comment' => $request->comment];
    event(new PusherEvent($posts));
    // コメントをデータベースに入れる
    $comment = new Comment;
    $comment->fill($request->all())->save();
    // ユーザー名を返す
    return response()->json(['user' => $user]);
});