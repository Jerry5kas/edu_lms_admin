<?php

use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Dashboard\StudentCourseController;
use App\Http\Controllers\Dashboard\InstructorCourseController;
use App\Http\Controllers\Dashboard\DashboardcardController;

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
Route::middleware(['auth']) // keep if your dashboard is protected
->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get('/', [DashboardcardController::class, 'index'])
            ->name('maindashboard.index'); // route name: dashboard.student.index
    });

Route::middleware(['auth']) // keep if your dashboard is protected
->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get('/student-courses', [StudentCourseController::class, 'index'])
            ->name('courses.student.index'); // route name: dashboard.student.index
    });
Route::middleware(['auth']) // keep if your dashboard is protected
->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get('/instructor-courses', [InstructorCourseController::class, 'index'])
            ->name('courses.master.index'); // route name: dashboard.student.index
    });

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('auth.profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('auth.profile.update');
});
Route::get('/', [WebAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [WebAuthController::class, 'login'])->name('login.post');

Route::middleware(['auth'])->group(function () {
    Route::post('logout', [WebAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [WebAuthController::class, 'dashboard'])->name('dashboard.index');
});

Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);



