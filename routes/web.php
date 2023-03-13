<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cms\ProductController;
use App\Http\Controllers\Cms\AuthController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\CartController;

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
Route::group(['prefix' => 'cms'], function() {
    Route::get('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/login', [AuthController::class, 'loginPost']);
    Route::get('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/register', [AuthController::class, 'registerPost']);

    Route::group(['middleware' => 'auth_cms'], function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        // product
        Route::get('/product/list', [ProductController::class, 'list']);
        Route::get('/product/detail/{id}', [ProductController::class, 'detail']);
        Route::post('/product/list', [ProductController::class, 'listData']);
        Route::post('/product/check-product-name', [ProductController::class, 'checkProductName']);
        Route::post('/product/add', [ProductController::class, 'store']);
        Route::post('/product/update', [ProductController::class, 'update']);
        Route::post('/product/delete', [ProductController::class, 'delete']);
    });
});

Route::get('/', [HomeController::class, 'home']);
Route::post('/login', [HomeController::class, 'loginPost']);
Route::post('/register', [HomeController::class, 'registerPost']);

Route::group(['middleware' => 'auth_website'], function () {
    Route::post('/logout', [HomeController::class, 'logout']);

    // cart
    Route::get('/cart/list', [CartController::class, 'list']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::post('/cart/checkout', [CartController::class, 'checkout']);
});
