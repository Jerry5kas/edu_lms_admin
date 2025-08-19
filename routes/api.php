<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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
