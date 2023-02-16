<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth; # This is responsible for handling the authentication
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{  # Save the image inside the storage/app/public/images
    private $post;
    const LOCAL_STORAGE_FOLDER = 'public/images/';

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    // public function index(Post $post)
    // {
    //     $post = Post::latest()->get();
    
    //     return view('post.index')->with('post', $post);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $all_categories = Category::all();
        return view('users.post.create')->with('all_categories',$all_categories);
                                        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        
        $this->post->user_id = Auth::id(); //post テーブルにあるuser_id というcolumn に　”今ログインしているユーザーの id” を入れ込む
        $this->post->image = $this->saveImage($request);  //$request = contain all data from <form>
        $this->post->description = $request->description;
        $this->post->save();
       
        //save categories [1,2,3] -> [category_id => 1, category_id =>2, ...]
        foreach($request->category as $category_id){
            $category_post[] = ["category_id" => $category_id];
        }
        $this->post->CategoryPost()->createMany($category_post);

        return redirect()->route('index');
    }

       
    public function saveImage($request){    //form から
        # To Overwriting
        $image_name = time() . "." . $request->image->extension();
        $request->image->storeAs(self::LOCAL_STORAGE_FOLDER, $image_name);

        return $image_name;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('users.post.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // if(Auth::user()->id != $post->user->id): //validation if the editor of the post is the owner
        //     return redirect()->route('index');
        // endif;
        $all_categories = Category::all(); // all the categories inside the category table
        //⬇️ あってもなくてもいい（line 109 で定義しているから）
        $selected_categories = []; // blank array that will hold category_id's inside the category_post table / 意：category_post table のデータをarray として保持する為に $selected_categories という空のarray box　を作成　 
        foreach($post->CategoryPost as $category_post): // CategoryPost : category_post テーブルのデータを取得
            $selected_categories[] = $category_post->category_id;
        endforeach;
        // $selected_categories = [1,2]

        return view('users.post.edit')
                ->with('post',$post)
                ->with('all_categories',$all_categories)
                ->with('selected_categories',$selected_categories);
 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
    
        $post->description = $request->description;
        if($request->image):
            $this->deleteImage($post->image);

            $post->image = $this->saveImage($request);
        endif;
        $post->save();

        $post->CategoryPost()->delete(); // delete all prevoiously selected categories

        if($request->category){
            foreach($request->category as $category_id):
                $category_post[] = ["category_id"=>$category_id];
            endforeach;

            $post->CategoryPost()->createMany($category_post);
        }

        

        return redirect()->route('post.show',$post);
    }

    public function deleteImage($image_name){
        $image_path = self::LOCAL_STORAGE_FOLDER.$image_name;

        if(Storage::disk('local')->exists($image_path)):
            Storage::disk('local')->delete($image_path);
        endif;
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->back();

        //              ⬇️ ()内で削除する id をしてやらないと Too few argument が出る！
        // Post::destroy($post->id);
        // return back();
    }
}
