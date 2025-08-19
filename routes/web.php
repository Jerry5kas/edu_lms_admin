<?php

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


use App\Http\Controllers\Admin\Auth\RegisterController;

// // Group all admin routes
// Route::prefix('admin')->name('admin.')->group(function () {
//     Route::get('/register', [RegisterController::class, 'create'])->name('register');       // GET /admin/register
//     Route::post('/register', [RegisterController::class, 'store'])->name('register.store'); // POST /admin/register
// });



Route::get('/', function () {
    return view('admin.register');
})->name('admin.register');

Route::get('/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::post('/', function () {
    // Process registration form data here
    // For now, just redirect to dashboard
    return redirect()->route('admin.dashboard');
})->name('admin.register.store');

Route::post('/login', function () {
    // Process registration form data here
    // For now, just redirect to dashboard
    return redirect()->route('admin.dashboard');
})->name('admin.login.store');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard.index');
})->name('admin.dashboard');


