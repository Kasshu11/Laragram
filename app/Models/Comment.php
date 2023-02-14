<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function user(){  //複数の comment は一つの post に書かれ、その post は書き手(user) の所有物だから
        return $this->belongsTo(User::class)->withTrashed();
    }
 
}
