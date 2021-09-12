<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//api ve thong tin cua nguoi su dung
Route::get('/profile', [App\Http\Controllers\API\UserController::class, 'show'])->name('apiProfile')->middleware('user');
Route::get('/listuser', [App\Http\Controllers\API\UserController::class, 'listUser'])->middleware('admin');
//update thong tin nguoi dung
Route::put('/profile', [App\Http\Controllers\API\UserController::class, 'updateDetail'])->middleware('user');

//api toan bo san pham 
Route::get('/products', [App\Http\Controllers\API\ProductController::class, 'index']);
//Route::get('product/{id}', [App\Http\Controllers\API\ProductController::class, 'show']);
//Route::get('product/search/{keyword}', [App\Http\Controllers\API\ProductController::class, 'search']);
Route::get('/product/{id}', [App\Http\Controllers\API\ProductController::class, 'prodDetail']);
// api lay nhung san pham ban chay nhat
Route::get('/topproduct', [App\Http\Controllers\API\ProductController::class, 'hotProduct']);
//api lay nhung san pham moi nhat
Route::get('/newproduct', [App\Http\Controllers\API\ProductController::class, 'newProduct']);
// api don hang
Route::post('/order', [App\Http\Controllers\API\OrderController::class, 'store'])->middleware('user');
Route::get('/listorder', [App\Http\Controllers\API\OrderController::class, 'listOrder'])->middleware('user');
Route::get('/myorder', [App\Http\Controllers\API\OrderController::class, 'manageOrder'])->middleware('user');
//api danh muc san pham
Route::get('category', [App\Http\Controllers\API\CategoryController::class, 'index']);
Route::get('categories/{id}', [App\Http\Controllers\API\CategoryController::class, 'show']);
Route::get('category/{id}', [App\Http\Controllers\API\CategoryController::class, 'productInCategory']);
//api dang xuat
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->middleware('user');
//api update anh
Route::post('/profile/avatar', [App\Http\Controllers\API\UserController::class, 'updateAvatar'])->middleware('user');

//get comment trong 1 san pham
Route::get('/product/comments/{id}', [App\Http\Controllers\API\ProductController::class, 'comment']);
//post comment
Route::post('/comment', [App\Http\Controllers\API\ProductController::class, 'postcomment'])->middleware('user');

//api get message by channel
Route::get('/messages', [App\Http\Controllers\API\MessageController::class, 'index']);
//api get by channel
Route::get('/messages/{id}', [App\Http\Controllers\API\MessageController::class, 'getMessage']);
//api
Route::post('/messages', [App\Http\Controllers\API\MessageController::class, 'store']);
Route::post('/messagerespond', [App\Http\Controllers\API\MessageController::class, 'requestBot']);
//qpi get list message
Route::get('/listmessages', [App\Http\Controllers\API\MessageController::class, 'listMessage'])->middleware('admin');
//api get bot's message 
Route::get('/msgrespond', [App\Http\Controllers\API\MessageController::class, 'msgResponse']);
