<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Events\PusherEvent;
use App\Http\Requests\ChatRequest;
use App\Services\UserSession;
use Session;

class ChatController extends Controller
{
    // チャットルーム名を受け取って、ルーム内のチャットを呼び出す
    public function index ($roomName) {
        // 登録されているチャットをすべて取得する
        $comments = Comment::all();
        // セッションの更新
        Session::regenerate();
        // セッションによってユーザー名を管理する
        $userSession = new UserSession();
        $user = $userSession->SessionConfirm("get",'');
        // $user = $this::sessionControl("get",'');
        // コメントとユーザー情報を表示する
        return view('chat',compact(['comments','user']));
    }

    // チャットを投稿する
    public function chat($roomName,ChatRequest $request){
        // セッションによってユーザー名を管理する
        $userSession = new UserSession();
        $user = $userSession->SessionConfirm("post",$request->user);
        // $user = $this::sessionControl("post",$request->user);
        $posts = ['user' => $user, 'comment' => $request->comment];
        event(new PusherEvent($posts));
        // コメントをデータベースに入れる
        $comment = new Comment;
        $comment->fill($request->all())->save();
        // ユーザー名を返す
        return response()->json(['user' => $user]);
    }

    // セッションからユーザー情報を取得する、
    // あるいはセットする
    private static function sessionControl(String $GetOrPost, String $user){
        // セッションにユーザー名があるか確認する
        $exist = Session::has('user');
        // あれば、そのまま変数に保存
        if($exist){
            $user = Session::get('user');
        // なければ、nullを設定する
        } else {
            // GETかつSessionに保存がなかった場合
            if($GetOrPost == "get"){
                $user = null;
            }
            // POSTかつSessionに保存がなかった場合
            if($GetOrPost == "post"){
                // ユーザーをセッションに登録する
                Session::put('user', $user);
            }
        }
        return $user;
    }
}
