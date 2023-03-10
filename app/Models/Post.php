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
    }                                         // ð¼ ã³ã¡ã³ããæ°ããé ã«è¡¨ç¤ºãã

    public function likes(){
        return $this->hasMany(Like::class);
    }       

    public function isLiked(){
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
        // select * from likes where user_id =  ???                // ð¼ true or false ãè¿ã
    }   // => user_id ã¨ãã columnå ã«ã­ã°ã¤ã³èã® id ãããã° true / ç¡ããã° false                                            
    
}
