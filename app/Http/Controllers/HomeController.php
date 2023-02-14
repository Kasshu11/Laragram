<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $all_posts = Post::latest()->get();
        $all_users = User::latest()->get();
        // $all = $all_posts->union($all_users);

        $suggested_users = $this->getSuggesterUsers();
    
        // ⬇️ $all_posts にフィルターをかける（フォローしている　||　post　の id が自分の id と同じもの）
        $home_post = [];
        foreach ($all_posts as $post) :
            if ($post->user->isFollowed() || Auth::user()->id == $post->user->id) :
                $home_post[] = $post;
            endif;
        endforeach;

        if(!empty($request->search)){
            $this->search($request);
        }
                                        
        return view('users.home')
                            // ⬇️ 'home_post' にしちゃうと Undefine $all_posts のエラーだ出る (‘’内の名前が blade.php に行く)
                    ->with('all_posts', $home_post) //つまり名前は $all_posts だけどその中身はフィルター後の $home_post が入った状態で home.blade.php に渡される！
                    ->with('suggested_users', $suggested_users);
                    // ->with('all_data', $all_data);
    }

    public function getSuggesterUsers()
    {
        $all_users = User::all()->except(Auth::user()->id);
        $suggested_users = [];

        // ⬇️ $all_users にかけるフィルター
        foreach ($all_users as $user) :
            if (!$user->isFollowed()) : //if user is not followed
                $suggested_users[] = $user;
            endif;

        endforeach;

        return $suggested_users;
    }

    public function search(Request $request)
    {
        $word = $request->search;
        $searchUser = User::where('name','like','%'.$word.'%')
                                ->orwhere('email','like','%'.$word.'%')
                                ->orderBy('created_at', 'DESC');

        $searchPost = Post::where('description','like','%'.$word.'%')
                                ->orderBy('created_at', 'DESC');
        // $user_data = User::WHERE('name', 'LIKE', '%' .$word . '%');
        // $post_data = Post::WHERE('description', 'LIKE', '%' .$word . '%');

        $all_data = $searchPost->union($searchUser);

        return $all_data;
    }
}
