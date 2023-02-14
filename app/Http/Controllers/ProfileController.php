<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth; # This is responsible for handling the authentication
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    const LOCAL_STORAGE_FOLDER = "public/avatars";

    private $user;

    public function __construct(User $user){
        $user = $this->user;
    }

    public function show($id)
    {
        //
        $user = User::findOrFail($id);


        return view('users.profile.show')->with('user',$user);
    }


    public function edit($id){
       
        $user =  User::findOrFail($id);
        return view('users.profile.edit')->with('user', $user);
    }

    public function update(Request $request, $id){

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        // if the user uploaded an avatar
        if ($request->avatar) { //もし写真が選択されていた場合 / avatar come from the name of input
            if($user->avatar){  // データベースに既存の写真があったら
                $this->deleteAvatar(); //既存の写真を削除（データベースから）
            }
            // Move the new one to local storage
            $user->avatar = $this->saveAvatar($request);
                                // 🔼 method名 : line 60
        }
        $user->save();
        return redirect()->route('profile.show', $id);
       
      
    }

    public function saveAvatar($request){
        // Rename the file to the current time to avoid overwritten
        $avatar_name = time() . "." . $request->avatar->extension();
        // $avatar_name = 12345678.jpeg
        //                🔼 time()　🔼 extension()

        $request->avatar->storeAs(self::LOCAL_STORAGE_FOLDER, $avatar_name);

        return $avatar_name;
    }

    public function deleteAvatar($avatar_name){
        $avatar_path = self::LOCAL_STORAGE_FOLDER . $avatar_name;
        // The avatar_path = "public/avatars/1234567.jpeg"

        if (Storage::disk('local')->exists($avatar_path)) {
            Storage::disk('local')->delete($avatar_path);
        }
    }
    
}


