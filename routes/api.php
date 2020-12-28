<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

    
Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class, 'register']);
Route::post('/recovery/{token}',[AuthController::class,'recovery']);//password reset
Route::post('/recovery',[AuthController::class,'recovery']);
//Route::post('recovery',[AuthController::class,'new_passowrd']);


Route::middleware('auth:api')->group(function($router){
    
    
    Route::get('/user',[UserController::class,'show'])->middleware(['can:view,App\User']);
    Route::put('/user/{user}',[UserController::class,'update'])->middleware(['can:update,user']);

    Route::get('/posts',[PostsController::class,'index']);
    Route::get('/posts/{post}',[PostsController::class,'show']);//izmijeniti {post} u {id} ?
    Route::post('/posts',[PostsController::class,'store'])->middleware(['can:create,App\Posts']);
    Route::put('/posts/{post}',[PostsController::class,'update'])->middleware(['can:update,post']);
    Route::delete('/posts/{post}',[PostsController::class,'destroy'])->middleware(['can:delete,post']);
    

    Route::get('/posts/{post}/comments',[CommentsController::class,'index']);
    Route::post('/posts/{post}/comments',[CommentsController::class,'store'])->middleware(['can:create,App\Comments']);
    Route::put('/posts/{post}/comments/{comment}',[CommentsController::class,'update'])->middleware(['can:update,comment']);
    Route::delete('/posts/{post}/comments/{comment}',[CommentsController::class,'destroy'])->middleware('can:delete,comment');


    
    Route::get('/posts/{post}/likes',[LikeController::class,'index']);
    Route::post('/posts/{post}/like',[LikeController::class,'like']);//like
    Route::post('/posts/{post}/dislike',[LikeController::class,'dislike']); //dislike
    Route::delete('/posts/{post}/like',[LikeController::class,'destroyLike']);//unlike
    Route::delete('/posts/{post}/dislike',[LikeController::class,'destroyLike']);//undislike
});


