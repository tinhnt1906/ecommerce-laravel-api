<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendController;
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
Route::get('search/{search}', [FrontendController::class, 'search']);
Route::get('get-categories', [FrontendController::class, 'getCategories']);


Route::middleware(['api','isAdmin'])->group(function () {
    Route::post('categories/{category}', [CategoryController::class, 'update']);
    Route::apiResource('categories', CategoryController::class);

    Route::post('products/{product}', [ProductController::class, 'update']);
    Route::apiResource('products', ProductController::class);
});



Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});
