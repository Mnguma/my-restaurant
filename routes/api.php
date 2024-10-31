<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderdetailsController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//Route::middleware(['auth:sanctum'])->group(function() {
    Route::apiResources([
        'categories' => CategoryController::class,
        'menus' => MenuController::class,
        'orders' => OrdersController::class,
        'payment' => PaymentController::class,
        'orderdetails' => OrderdetailsController::class,
    ]);

    route::get('getOrderDetails/{id}', [OrdersController::class,'getOrderDetails']);
// });