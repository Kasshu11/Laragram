<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;
use App\Models\Comment;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    
// Soft Delete を使うため
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public function post(){
        return $this->hasMany(Post::class);
    }

    public function followers(){
        return $this->hasMany(Follow::class,'following_id'); // select follower_id from followers where following_id = Auth::id(), getting the list of your followers
                                                             // following column にある自分の id の数　＝　自分がフォローしている人数
    }

    public function following(){
        return $this->hasMany(Follow::class,'follower_id');// getting the list of your followings
    }                                                      // follower_id column にある自分の id の数　＝　自分のフォロワー数
                                                           // 自分が誰かをフォローすれば自分の id は follower_id に追加される（誰かにとって自分はフォロワーに当たる）
                                                           // 同時に誰かの id は following_id に追加される（自分にとって誰かはフォローしているユーザーに当たる）

    public function isFollowed(){
        return $this->followers()->where('follower_id',Auth::user()->id)->exists(); //TIP: helps you solve the suggested users
    } // =>相手の follower にログイン者の id があれば true / 無ければ false                                            
    

    
}
