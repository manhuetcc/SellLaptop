<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Quản trị hệ thống cho Admin
Route::get('/admin', [App\Http\Controllers\Admin\AdminController::class, 'index'])->middleware('checkAdmin')->name('adminIndex');
//Quuản lý category và product
Route::resource(
    '/category',
    'Admin\AdminCategoryController',
    [
        'names' => 'adminCategory'
    ]
);
// Route quản trị sản phẩm
Route::resource(
    '/product',
    'Admin\AdminProductController',
    [
        'names' => 'adminProduct'
    ]
);
