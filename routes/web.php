<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ProductController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[LoginController::class,'index'])->name('login');

Route::post('login-check',[LoginController::class,'loginCheck'])->name('login-check');

Route::prefix('admin/')->name('admin.')->middleware(['auth'])->group(function (){
    
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('logout',[LoginController::class,'logout'])->name('logout');

    Route::prefix('category/')->name('category.')->middleware(['auth'])->group(function () {

         Route::get('/',[CategoryController::class,'index'])->name('list');
         Route::get('create',[CategoryController::class,'create'])->name('create');
         Route::post('store',[CategoryController::class,'store'])->name('store');
         Route::post('list-category',[CategoryController::class,'listCategory'])->name('list-category');
         Route::get('edit/{id}',[CategoryController::class,'edit'])->name('edit');
         Route::post('update/{id}',[CategoryController::class,'update'])->name('update');
         Route::get('status-change/{id}/{status}', [CategoryController::class,'changeStatus'])->name('status-change');
         Route::delete('delete/{id}', [CategoryController::class,'destroy'])->name('delete');

    
    });

    Route::prefix('product/')->name('product.')->middleware(['auth'])->group(function () {
       
        Route::get('/',[ProductController::class,'index'])->name('list');
        Route::get('create',[ProductController::class,'create'])->name('create');
        Route::post('store',[ProductController::class,'store'])->name('store');
        Route::post('list-product',[ProductController::class,'listProduct'])->name('list-product');
        Route::get('edit/{id}',[ProductController::class,'edit'])->name('edit');
        Route::post('update/{id}',[ProductController::class,'update'])->name('update');
        Route::get('status-change/{id}/{status}', [ProductController::class,'changeStatus'])->name('status-change');
        Route::delete('delete/{id}', [ProductController::class,'destroy'])->name('delete');
       
     });

     Route::prefix('order/')->name('order.')->middleware(['auth'])->group(function () {
       
        Route::get('/',[OrderController::class,'index'])->name('list');
        Route::get('create/{id}',[OrderController::class,'create'])->name('create');
        Route::post('store',[OrderController::class,'store'])->name('store');
        Route::post('list-order',[OrderController::class,'listProduct'])->name('list-order');
        Route::post('update/{id}',[OrderController::class,'update'])->name('update');

        Route::post('store-product/{id}',[OrderController::class,'storeproduct'])->name('store-product');
        Route::get('delete-product/{id}', [OrderController::class, 'deleteProduct'])->name('delete-product');
        Route::get('edit-product/{id}', [OrderController::class, 'editProduct'])->name('edit-product');
        Route::post('update-product/{id}', [OrderController::class, 'updateProduct'])->name('update-product');

        Route::delete('delete-order/{id}',[OrderController::class,'deleteOrder'])->name('delete-order');
        Route::get('view/{id}',[OrderController::class,'view'])->name('view');
        Route::get('download-invoice/{id}',[OrderController::class,'downloadInvoice'])->name('download-invoice');
       
     });

});