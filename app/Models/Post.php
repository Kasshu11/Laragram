<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;

    use SoftDeletes;


    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function CategoryPost(){
        return $this->hasMany(CategoryPost::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class)->latest();
    }                                         // 🔼 コメントを新しい順に表示する

    public function likes(){
        return $this->hasMany(Like::class);
    }       

    public function isLiked(){
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
        // select * from likes where user_id =  ???                // 🔼 true or false を返す
    }   // => user_id という column名 にログイン者の id があれば true / 無ければ false                                            
    
}
