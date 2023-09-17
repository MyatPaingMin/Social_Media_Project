<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\apiList\ActionController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\apiList\PostController;
use App\Http\Controllers\apiList\CommentController;
use App\Http\Controllers\apiList\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/tokenCheck',function(){
    return response()->json([
        'message' => 'Valid Token'
    ]);
})->middleware('auth:sanctum');

Route::post('/user/check',[UserController::class,'checkUser']);
Route::post('/user/create',[UserController::class,'createUser']);
Route::post('/user/currentUser',[UserController::class,'currentUser']);

//Customer view
Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::get('/logoutUser',[UserController::class,'logoutUser']);

    Route::get('/currentUser',[UserController::class,'currentUser']);

    Route::get('/allpost',[PostController::class,'allPost']);
    Route::get('/totalPosts',[PostController::class,'totalPosts']);
    Route::post('/postSearch',[PostController::class,'postSearch']);
    Route::get('/postCall/{postID}/{userID}',[PostController::class,'postCall']);//postID,userID
    Route::post('/categorySearch',[CategoryController::class,'categorySearch']);
    Route::get('/allCategory',[CategoryController::class,'allCategory']);

    Route::get('/comment/{id}/{commentlimit}',[CommentController::class,'commentlist']);//lazy
    Route::get('/onecomment/{id}/{commentID}',[CommentController::class,'onecomment']);//lazy
    Route::post('/createComment',[CommentController::class,'createComment']);//userID,postID,text,parent
    Route::patch('/editComment',[CommentController::class,'editComment']);//commentID,text
    Route::delete('/deleteComment/{commentID}',[CommentController::class,'deleteComment']);//commentID
    Route::post('/updateComment',[CommentController::class,'updateComment']);//commentID,text

    Route::patch('/postViewInc',[ActionController::class,'postViewInc']);//postID,userID
    Route::post('/reactpost',[ActionController::class,'reactpost']);//postID,react
    Route::get('/postReload/{postID}/{userID}',[PostController::class,'postReload']);//postID,react
    Route::post('/giveReact',[ActionController::class,'giveReact']);//react,userID,postID
    Route::post('/changeReact',[ActionController::class,'changeReact']);//react,userID,postID
    Route::delete('/deleteReact',[ActionController::class,'deleteReact']);//userID,postID
    Route::get('/react/{id}/{reactlimit}',[ActionController::class,'reactlist']);//postID

    Route::get('/postList/{userID}/{postLimit}',[PostController::class,'postList']);//user_id,postLimit

});


