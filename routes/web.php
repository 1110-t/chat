<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Events\PusherEvent;
use App\Http\Requests\ChatRequest;
use App\Http\Controllers\ChatController;

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

Route::get('/update', function () {
    // 最初の更新対象となる行を取得する
    $target = Comment::orderBy('id','asc')->where('id',4)->first();
    // 基準となるidの値
    $tar_id = $target['id'];
    // 何行更新するかを決める
    $count = Comment::orderBy('id','asc')->where('id','>=',$target['id'])->count();
    // 更新行まとめ
    $updates = [];
    // 更新する行の情報を配列で生成する
    for($i = 0; $i < $count; $i++){
        $temp = ['id' => $tar_id, 'user' => 'aiueo', 'comment' => 'なにぬねの'];
        array_push($updates, $temp);
        $tar_id += 1;
    };
    // 第一引数に更新内容すべて、第二引数にどこの値を基準に更新するかを設定、第三引数に更新したい列名を設定
    Comment::upsert($updates,['id'],['user','comment']);
    dd($count);
});

Route::prefix('chat')->group(function (){
    // チャットルームに接続して、チャットを見る
    Route::get('{roomName}', [ChatController::class, 'index']);
    // チャットを投稿する
    Route::post('{roomName}', [ChatController::class, 'chat']);
});