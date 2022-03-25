<?php

namespace App\Services;
use App\Interfaces\SessionControl;
use Session;

class UserSession implements SessionControl{
    public function SessionConfirm(String $GetOrPost, String $user){
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