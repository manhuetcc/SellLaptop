<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminCategoryController;
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
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Quản trị hệ thống cho Admin
Route::get('/admin', [App\Http\Controllers\Admin\AdminController::class, 'index'])->middleware('admin')->name('adminIndex');
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::resource(
        'categories',
        'Admin\AdminCategoryController'
    )->names('adminCategory');
    Route::resource(
        '/products',
        'Admin\AdminProductController',
        [
            'names' => 'adminProduct'
        ]
    );
    Route::get('/product/{product_id}/info', [App\Http\Controllers\Admin\AdminInfoProductController::class, 'listInfo'])->name('listInfoProduct');
    Route::post('/product/{product_id}/info', [App\Http\Controllers\Admin\AdminInfoProductController::class, 'createInfo'])->name('createInfoProduct');
    Route::get('/product/{product_id}/info/{info_id}', [App\Http\Controllers\Admin\AdminInfoProductController::class, 'editInfo'])->name('editInfoProduct');
    Route::put('/product/{product_id}/info/{info_id}', [App\Http\Controllers\Admin\AdminInfoProductController::class, 'updateInfo'])->name('updateInfoProduct');
    Route::delete('/product/{product_id}/info/{info_id}', [App\Http\Controllers\Admin\AdminInfoProductController::class, 'delete'])->name('deleteInfoProduct');
    //quan tri don hang
    Route::get(
        'order/listordered',
        [App\Http\Controllers\Admin\AdminOrderController::class, 'listOrdered']
    )->name('listOrdered');
    Route::get('order/listconfirmed', [App\Http\Controllers\Admin\AdminOrderController::class, 'listConfirmed'])->name('listConfirmed');
    Route::get('order/listcompleted', [App\Http\Controllers\Admin\AdminOrderController::class, 'listCompleted'])->name('listCompleted');
    //xu ly cac su kien
    Route::put('/order/delete/{order_id}', [App\Http\Controllers\Admin\AdminOrderController::class, 'delete'])->name('deleteOrder');
    Route::get('/order/{order_id}', [App\Http\Controllers\Admin\AdminOrderController::class, 'confirmOrder'])->name('confirmOrder');
    Route::get('/order/shipped/{order_id}', [App\Http\Controllers\Admin\AdminOrderController::class, 'shipped'])->name('shippedOrder');
});
//Quản lý category và product

// Route quản trị sản phẩm*/
Route::get('/{url}', function () {
    return view('welcome');
})->where('url', '[A-Za-z0-9/-]+');
