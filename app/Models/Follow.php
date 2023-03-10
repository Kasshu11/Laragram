<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    public $timestamps = false;
    //ăđŒ migration ăäœăæă« table->timestamps(); ăæ¶ăăăăăźăłăŒăăæžăăȘăăšăšă©ăŒè”·ăăïŒ

    public function follower(){
        return $this->belongsTo(User::class,'follower_id')->withTrashed(); // gives data to your followers (name,email)
    }                                                       // User.php ăšăŻéïŒ

    public function following(){
        return $this->belongsTo(User::class,'following_id')->withTrashed(); //gives data to your following (name,email)
    }
}
