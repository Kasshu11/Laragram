<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;


class PostsController extends Controller
{
    public function index()
    {
        //
        $all_posts = Post::withTrashed()->latest()->get();
        return view('admin.posts.index')->with('all_posts',$all_posts);
                            
    }


    public function update($id)
    {
        Post::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back();
      
    }


    public function destroy($id)
    {
        //
        Post::destroy($id);

        return redirect()->back();
    }
}
