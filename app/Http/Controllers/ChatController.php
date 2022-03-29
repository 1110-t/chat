<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Events\PusherEvent;
use App\Http\Requests\ChatRequest;
use App\Services\UserSession;
use App\Interfaces\SessionControl;
use Session;

class ChatController extends Controller
{
    // チャットルーム名を受け取って、ルーム内のチャットを呼び出す
    public function index ($roomName,SessionControl $sessionControl) {
        // 登録されているチャットをすべて取得する
        $comments = Comment::all();
        // セッションの更新
        Session::regenerate();
        $user = $sessionControl->SessionConfirm("get",'');
        // $user = $this::sessionControl("get",'');
        // コメントとユーザー情報を表示する
        return view('chat',compact(['comments','user']));
    }

    // チャットを投稿する
    public function chat($roomName,ChatRequest $request,SessionControl $sessionControl){
        // セッションによってユーザー名を管理する
        $user = $sessionControl->SessionConfirm("post",$request->user);
        // $user = $this::sessionControl("post",$request->user);
        $posts = ['user' => $user, 'comment' => $request->comment];
        event(new PusherEvent($posts));
        // コメントをデータベースに入れる
        $comment = new Comment;
        $comment->fill($request->all())->save();
        // ユーザー名を返す
        return response()->json(['user' => $user]);
    }
}
