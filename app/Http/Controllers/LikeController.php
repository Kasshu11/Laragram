<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; # This is responsible for handling the authentication

class LikeController extends Controller
{

    private $like;

    public function __construct(Like $like){

        $this->like = $like;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Like $like)
    {
        $data = $like->exists();
        if($data){
            $like->delete(Auth::user()->id);
        }
        $this->like->user_id = Auth::user()->id;
        $this->like->post_id = $request->post_id;
        $this->like->save();

        return redirect()->back();
        
    }
 


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LikeOrUnlike  $likeOrUnlike
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LikeOrUnlike  $likeOrUnlike
     * @return \Illuminate\Http\Response
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LikeOrUnlike  $likeOrUnlike
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LikeOrUnlike  $likeOrUnlike
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->like->where('user_id', Auth::user()->id)->where('post_id', $id)->delete();
        //destroy : accept array ex) $this->destroy(1,2,3); =>it'll work
        //delete  : not accept array => findOrFail(), where()でまず消す対象を見つけなきゃいけない

        return redirect()->back();
    }
}
