<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderDetailController;
use App\Http\Controllers\Api\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthController::class,'register']);
Route::post('login', [AuthController::class, 'login']);


Route::get('admin-dashboard', [DashboardController::class, 'index']);
Route::get('user-dashboard', [DashboardController::class, 'userIndex']);

Route::get('list-products', [ProductController::class, 'index']);
Route::post('add-product', [ProductController::class, 'store']);
Route::get('edit-product/{id}', [ProductController::class, 'edit']);
Route::post('update-product', [ProductController::class, 'update']);
Route::get('delete-product/{id}', [ProductController::class, 'delete']);
Route::get('get-product-slug/{slug}', [ProductController::class, 'getBySlug']);

Route::get('list-category', [CategoryController::class, 'index']);
Route::post('add-category', [CategoryController::class, 'store']);
Route::get('edit-category/{id}', [CategoryController::class, 'edit']);
Route::post('update-category', [CategoryController::class, 'update']);
Route::get('delete-category/{id}', [CategoryController::class, 'destroy']);

Route::get('list-blogs', [BlogController::class, 'index']);
Route::post('add-blog', [BlogController::class, 'store']);
Route::get('edit-blog/{id}', [BlogController::class, 'edit']);
Route::post('update-blog', [BlogController::class, 'update']);
Route::get('delete-blog/{id}', [BlogController::class, 'destroy']);
Route::get('search-blog', [BlogController::class, 'getBlogBySearch']);
Route::get('get-blog-slug/{slug}', [BlogController::class, 'getBySlug']);
Route::get('blog-by-category/{id}', [BlogController::class, 'getByCategory']);

Route::get('list-cart/{userId}', [CartController::class, 'index']);
Route::post('add-cart', [CartController::class, 'store']);
Route::post('update-cart', [CartController::class, 'update']);
Route::get('delete-cart/{id}/{userId}', [CartController::class, 'destroy']);


Route::get('orders', [OrderController::class, 'all']);
Route::get('list-order/{userId}', [OrderController::class, 'index']);
Route::post('place-order', [OrderController::class, 'store']);
Route::get('delete-order/{id}', [OrderController::class, 'destroy']);
Route::get('status-order/{id}/{status_id}', [OrderController::class, 'status']);


Route::get('order-detail/{order_id}', [OrderDetailController::class, 'index']);
