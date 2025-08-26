<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//
//Route::middleware(['api.client', 'rate.limit:100,minute'])->group(function () {
//    Route::get('/courses', [\App\Http\Controllers\Api\CourseController::class, 'index']);
//    Route::get('/orders', [\App\Http\Controllers\Api\OrderController::class, 'index']);
//});


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (requires Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Order Management API
    Route::prefix('orders')->group(function () {
        Route::get('/my-orders', [\App\Http\Controllers\Api\OrderApiController::class, 'myOrders']);
        Route::get('/statistics', [\App\Http\Controllers\Api\OrderApiController::class, 'statistics']);
        Route::get('/available-courses', [\App\Http\Controllers\Api\OrderApiController::class, 'availableCourses']);
        Route::post('/', [\App\Http\Controllers\Api\OrderApiController::class, 'store']);
        Route::get('/{order}', [\App\Http\Controllers\Api\OrderApiController::class, 'show']);
        Route::patch('/{order}/cancel', [\App\Http\Controllers\Api\OrderApiController::class, 'cancel']);
        Route::get('/{order}/payment-link', [\App\Http\Controllers\Api\OrderApiController::class, 'getPaymentLink']);
        Route::post('/verify-payment', [\App\Http\Controllers\Api\OrderApiController::class, 'verifyPayment']);
    });
});
