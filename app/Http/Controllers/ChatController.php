<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Comment;
use App\Events\PusherEvent;
use App\Events\RoomEvent;
use App\Http\Requests\ChatRequest;
use App\Services\UserSession;
use App\Interfaces\SessionControl;
use Illuminate\Support\Facades\DB;
use Session;

class ChatController extends Controller
{
    // 登録されている部屋を一覧で出す
    public function rooms(Request $request){
        // チャットルームを全て取得する
        $rooms = Room::get()->all();
        return view('room',compact(['rooms']));
    }
    // チャットルームを追加する
    public function roomAdd(Request $request){
        // 新しいルームオブジェクトを生成する
        $room = new Room;
        // データベースに追加する
        $room->fill($request->all())->save();
        // Pusherからデータを送信するためにイベントを生成する
        $posts = ['name' => $request->name];
        event(new RoomEvent($posts));
    }
    // チャットルーム名を受け取って、ルーム内のチャットを呼び出す
    public function index ($roomNumber,SessionControl $sessionControl) {
        // 登録されているチャットをすべて取得する
        $comments = Room::find($roomNumber)->comments;
        // セッションの更新
        Session::regenerate();
        $user = $sessionControl->SessionConfirm("get",'');
        $room = $roomNumber;
        // $user = $this::sessionControl("get",'');
        // コメントとユーザー情報を表示する
        return view('chat',compact(['comments','user','room']));
    }
    // チャットを投稿する
    public function chat($roomName,ChatRequest $request,SessionControl $sessionControl){
        // セッションによってユーザー名を管理する
        $user = $sessionControl->SessionConfirm("post",$request->user);
        // $user = $this::sessionControl("post",$request->user);
        $posts = ['user' => $user, 'comment' => $request->comment];
        event(new PusherEvent($request->room,$posts));
        // コメントをデータベースに入れる
        $comment = new Comment;
        $comment->fill($request->all())->save();
        // ユーザー名を返す
        return response()->json(['user' => $user]);
    }
}
