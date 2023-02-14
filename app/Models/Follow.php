<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    public $timestamps = false;
    //　🔼 migration を作る時に table->timestamps(); を消したらこのコードを書かないとエラー起こす！

    public function follower(){
        return $this->belongsTo(User::class,'follower_id')->withTrashed(); // gives data to your followers (name,email)
    }                                                       // User.php とは逆！

    public function following(){
        return $this->belongsTo(User::class,'following_id')->withTrashed(); //gives data to your following (name,email)
    }
}
