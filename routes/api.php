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

//api toan bo san pham 
Route::get('products', [App\Http\Controllers\API\ProductController::class, 'show']);
//api dang xuat
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->middleware('user');;
