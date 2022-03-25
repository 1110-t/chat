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
    // チャットルームに接続して、チャットを見る
    Route::get('{roomName}', [ChatController::class, 'index']);
    // チャットを投稿する
    Route::post('{roomName}', [ChatController::class, 'chat']);
});