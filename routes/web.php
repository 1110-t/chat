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

Route::prefix('chat')->group(function (){
    // チャットルームを取得する
    Route::get('/',[ChatController::class, 'rooms']);
    Route::get('/dodo',[ChatController::class, 'dodo']);
    // チャットルームを追加する
    Route::post('/',[ChatController::class, 'roomAdd']);
    // チャットルームに接続して、チャットを見る
    Route::get('{roomNumber}', [ChatController::class, 'index']);
    // チャットを投稿する
    Route::post('{roomNumber}', [ChatController::class, 'chat']);
});