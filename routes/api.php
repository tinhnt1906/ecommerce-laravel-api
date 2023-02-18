<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
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

//GUST USER
Route::get('search/{search}', [FrontendController::class, 'search']);
Route::get('get-categories', [FrontendController::class, 'getCategories']);
Route::get('get-products-by-category/{slug}', [FrontendController::class, 'getProductsByCategory']);

//USERS LOGIN
Route::middleware(['api'])->group(function () {

    //carts
    Route::apiResource('carts', CartController::class);
    Route::get('total-cart', [CartController::class, 'totalCart']);

    //checkout
    Route::post('place-order', [CheckoutController::class, 'placeOrder']);

    //reviews
    Route::post('reviews', [ReviewController::class, 'store']);

    //Home
    Route::get('get-my-orders', [HomeController::class, 'getMyOrders']);
    Route::get('get-my-orders-completed', [HomeController::class, 'getMyOrdersCompleted']);
    Route::get('get-my-reviews', [HomeController::class, 'getMyReviews']);
    Route::post('change-password', [HomeController::class, 'changePassword']);
    Route::get('user-profile', [HomeController::class, 'userProfile']);
});

//ADMIN
Route::middleware(['api', 'isAdmin'])->group(function () {
    //CRUD category
    Route::post('categories/{category}', [CategoryController::class, 'update']);
    Route::apiResource('categories', CategoryController::class);

    //CRUD products
    Route::post('products/{product}', [ProductController::class, 'update']);
    Route::apiResource('products', ProductController::class);

    //CRUD coupons
    Route::post('coupons/{coupon}', [CouponController::class, 'update']);
    Route::apiResource('coupons', CouponController::class);

    //orders
    Route::post('orders/{order}', [OrderController::class, 'updateStatus']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{order}', [OrderController::class, 'show']);
});



//AUTH
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});
