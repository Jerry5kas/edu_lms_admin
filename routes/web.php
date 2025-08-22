<?php
use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ProfileController;
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

Route::get('/', [WebAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [WebAuthController::class, 'login'])->name('login.post');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('auth.profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('auth.profile.update');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('/courses', CourseController::class);
    Route::get('/instructor', [CourseController::class, 'instructor'])->name('instructor.courses.index');
    Route::resource('/categories', CategoryController::class);
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [WebAuthController::class, 'dashboard'])->name('dashboard.index');
});

Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::get('/test', function () {
    return view('test');
});

