<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /*
    * チャットが属するルーム
    */
    public function room(){
        return $this->belongsTo(Room::class);
    }
}
