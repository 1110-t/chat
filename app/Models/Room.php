<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    /*
    * ルーム内のコメントを取得する
    */
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
