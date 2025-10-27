<?php

use App\Http\Controllers\admin\orderController;
use App\Http\Controllers\admin\productController;
use App\Http\Controllers\admin\UploadController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OrderConfirmationController;
use App\Models\order;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
//--------------PHAN CUA ADMIN ----
Route::middleware(['auth', 'check.admin'])->group(function () {
// admin
Route::get('/admin', [AdminController::class, 'dashboard']);

Route::get('/admin/home', [AdminController::class, 'dashboard'])->name('admin.home');

//product
Route::get('/admin/product/create',[productController::class,'add_product']);
Route::post('/admin/product/add',[productController::class,'insert_product']);
Route::get('/admin/product/list',[productController::class,'list_product']);
Route::get('/admin/product/delete',[productController::class,'delete_product']);
Route::get('/admin/product/edit/{id}',[productController::class,'edit_product']);
Route::post('/admin/product/edit/{id}', [productController::class,'update_product']);


//order
Route::get('/admin/order/list',[orderController::class,'list_order']);
Route::get('/admin/order/details/{chitiet}',[orderController::class,'show_order']);
Route::delete('admin/order/delete/{id}', [orderController::class, 'delete_order']);
Route::post('/admin/order/complete/{id}', [orderController::class, 'complete_order']);


//image
Route::post('/upload',[UploadController::class,'uploadImage']);
Route::post('/uploads',[UploadController::class,'uploadImages']);
});

//--------------USER------------------------------------------------------------
Route::middleware(['auth'])->group(function () {
// cart
Route::post('/cart/add', [FrontendController::class,'addcart']);
Route::get('/cart', [FrontendController::class,'showcart']);
Route::post('/cart/showcheck', [FrontendController::class,'showcheck']);
Route::get('/cart/remove/{id}', [FrontendController::class,'removecart']);
Route::post('/cart/send',[FrontendController::class,'cart_send']);
Route::post('/cart/update', [FrontendController::class, 'update'])->name('cart.update');
Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');
});
// -------------- pHẦN KO CẦN ĐĂNG NHẬP --------------

// front-end
Route::get('/',[FrontendController::class,'index']);
Route::get('/product/{id}', [FrontendController::class,'showproduct']);
Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.store');

// Order Confirmation
Route::get('/order/confirm/{token}', [OrderConfirmationController::class, 'confirm'])->name('order.confirm');