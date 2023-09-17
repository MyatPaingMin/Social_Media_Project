<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['middleware'=>'accountAuth'],function(){
    Route::get('/', function () {
        return view('auth.login');
    })->name('loginPage');

    Route::get('/registerPage',function(){
        return view('registerPage');
    })->name('registerPage');

    Route::post('/loginUser',[UserController::class,'loginUser'])->name('loginUser');
    Route::post('/registerUser',[UserController::class,'registerUser'])->name('register');

});

Route::group(['prefix'=>'/admin','middleware'=>'adminAuth'],function(){
    Route::get('/home',[PostController::class,'adminhome'])->name('admin#home');
    Route::get('/pending',[UserController::class,'adminpending'])->name('admin#pending');
    Route::get('/profile',[UserController::class,'adminProfile'])->name('admin#profile');
    Route::get('/categorylist',[CategoryController::class,'categoryList'])->name('admin#categorylist');
    Route::get('/post',[PostController::class,'listpost'])->name('admin#listpost');
    Route::get('/userlist',[UserController::class,'adminUserlist'])->name('admin#userlist');
    Route::get('/adminApprove/{id}',[UserController::class,'adminApprove'])->name('admin#approve');
    Route::get('/adminDeny/{id}',[UserController::class,'adminDeny'])->name('admin#deny');
    Route::get('/userdetail/{id}',[UserController::class,'userDetail'])->name('userDetail');
    Route::get('/userdelete/{id}',[UserController::class,'userDelete'])->name('userDelete');
    Route::post('/userban',[UserController::class,'userBan'])->name('userBan');

    Route::get('/adminlist',[UserController::class,'adminAdminlist'])->name('admin#adminlist');
    Route::get('/admindetail/{id}',[UserController::class,'adminDetail'])->name('adminDetail');
    Route::get('/chat/{otheruser}',[ChatController::class,'adminChat'])->name('admin#chat');
    Route::get('/chatPage',[ChatController::class,'adminChatPage'])->name('admin#chatPage');
    Route::get('/notification',[UserController::class,'adminNotification'])->name('admin#notification');
    // Route::post('/sendMessage/{receiverID}',[ChatController::class,'sendMessage'])->name('admin#sendmessage');


    Route::group(['prefix'=>'/ajax'],function(){
        Route::get('/loadsearch',[PostController::class,'loadSearch'])->name('post#search');

        Route::get('/basic',[UserController::class,'adminBasic'])->name('admin#basic');
        Route::get('/currentUser',[UserController::class,'adminCurrentUser'])->name('admin#currentUser');
        Route::get('/notification',[UserController::class,'adminNotificationAmount'])->name('admin#notiAmt');

        Route::get('/seenmessage',[ChatController::class,'seenMessage'])->name('admin#seenmessage');
        Route::get('/deletemessage/{message_id}',[ChatController::class,'deleteMessage'])->name('admin#deletemessage');
        Route::get('/chatlist/{other_id}',[ChatController::class,'chatList'])->name('admin#chatlist');
        Route::get('/chatunseen',[ChatController::class,'chatunseen'])->name('admin#chatunseen');
        Route::post('/sendMessage/{receiverID}',[ChatController::class,'sendMessage'])->name('admin#sendmessage');

        Route::get('/comment/{id}/{limit}',[PostController::class,'commentLoad']);
        // Route::get('/react/{id}/{limit}',[PostController::class,'reactLoad']);

    });

    //profile
    Route::group(['prefix'=>'/profile'],function(){
        Route::get('/edit',[UserController::class,'profileEdit'])->name('profileEdit');
        Route::post('/update',[UserController::class,'profileUpdate'])->name('profileUpdate');
        Route::get('/photo',[UserController::class,'profilePhoto'])->name('profilePhoto');
        Route::post('/photoUpdate',[UserController::class,'profilePhotoUpdate'])->name('profilePhotoUpdate');
        Route::get('/password',[UserController::class,'profilePassword'])->name('profilePassword');
        Route::post('/password/update',[UserController::class,'profilePasswordUpdate'])->name('profilePasswordUpdate');
    });

    // category
    Route::group(['prefix'=>'/category'],function(){

        Route::get('/createCategory',[CategoryController::class,'createCategoryPage'])->name('createCategoryPage');
        Route::post('/create',[CategoryController::class,'CU_Category'])->name('createCategory');

        Route::get('/updateCategory/{id}',[CategoryController::class,'updateCategoryPage'])->name('updateCategoryPage');
        Route::post('/update',[CategoryController::class,'CU_Category'])->name('updateCategory');

        Route::get('/delete/{id}',[CategoryController::class,'deleteCategory'])->name('deleteCategory');

    });
    Route::get('/categoryOrder',[CategoryController::class,'orderCategory'])->name('orderCategory');


    //post
    Route::group(['prefix'=>'/post'],function(){
        Route::get('/get',[PostController::class,'getPost'])->name('getPost');
        Route::get('/createPage',[PostController::class,'createPostPage'])->name('createPostPage');
        Route::post('/create',[PostController::class,'CU_Post'])->name('createPost');

        Route::get('/seePost/{id}',[PostController::class,'seePost'])->name('seePost');

        Route::get('/updatePage/{id}',[PostController::class,'updatePostPage'])->name('updatePostPage');
        Route::post('/update',[PostController::class,'CU_Post'])->name('updatePost');

        Route::get('/delete/{id}',[PostController::class,'deletePost'])->name('deletePost');
    });

    //ban
    Route::get('/ban/user/{id}/{duration}',[UserController::class,'userBan'])->name('userBan');
    Route::get('/ban/detail/{id}',[UserController::class,'banDetail'])->name('banDetail');
    Route::get('/ban/unban/{id}',[UserController::class,'unban'])->name('unban');

});

Route::group(['prefix'=>'/user','middleware'=>'userAuth'],function(){
    Route::get('/home',[UserController::class,'userhome'])->name('user#home');
});

Route::get('/logout',function(){
    return view('logout');
})->name('logoutPage');

// Route::post('/loginUser',[UserController::class,'loginUser'])->name('login');
// Route::post('/register',UserController::class['registerUser'])->name('register');



// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function() {
//     Route::get('/dashboard', function() {
//         return view('dashboard');
//     })->name('dashboard');
// });
