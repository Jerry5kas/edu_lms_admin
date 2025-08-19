<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/',[AuthController::class,'showlogin'])->name('login');
Route::post('/login',[AuthController::class,'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::get('/dashboard', [AuthController::class,'dashboard'])->name('dashboard.index');

Route::get('auth/login', [SocialAuthController::class, 'redirectToGoogle'])->name('login');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
Route::get('/test', function () {
    return view('test');
});
