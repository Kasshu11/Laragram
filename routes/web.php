<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

// ⬇️ Route::group(["middleware"=>"auth"], function () {}); を使うことでログインしない限りこのgroup 内のどのrouteにもアクセス出来な苦なる
Route::group(["middleware"=>"auth"], function () {
     Route::get('/categories', [CategoryController::class, 'generateCategories']);
     Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
     Route::post('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');

     Route::resource('/post', PostController::class)->except('index');
     Route::resource('/comments', CommentController::class);
     Route::resource('/profile', ProfileController::class);
     Route::resource('/follow', FollowController::class);
     Route::resource('/like', LikeController::class)->except('index');

     Route::group(["prefix"=>"admin", "as"=>"admin."],function(){
          Route::resource('/users',UsersController::class); //admin.users.show
          Route::resource('/posts',PostsController::class); //admin.users.show
          Route::resource('/categories',CategoriesController::class); //admin.users.show
     });
});

