<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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

// Sanctum Auth
Route::prefix('auth')->group(static function (): void {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('get-user', [AuthController::class, 'userInfo']);
    });
});

Route::prefix('category')->group(static function (): void {
    Route::get('', [CategoryController::class, 'index']);
    Route::get('/{category_id}', [CategoryController::class, 'show']);
    Route::group(['middleware' => 'auth:sanctum'], static function (): void {
        Route::post('', [CategoryController::class, 'store']);
        Route::put('/{category_id}', [CategoryController::class, 'update']);
        Route::delete('/{category_id}', [CategoryController::class, 'destroy']);
    });
});

Route::prefix('product')->group(static function (): void {
    Route::get('/{product_id}', [ProductController::class, 'show']);
    Route::get('', [ProductController::class, 'index']);
    Route::group(['middleware' => 'auth:sanctum'], static function (): void {
        Route::post('', [ProductController::class, 'store']);
        Route::put('/{category_id}', [ProductController::class, 'update']);
        Route::delete('/{product_id}', [ProductController::class, 'destroy']);
    });
});
