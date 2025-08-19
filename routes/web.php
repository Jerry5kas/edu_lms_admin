<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
//*/
//
//Route::get('/', function () {
//    return view('auth.register');   // Register Page
//})->name('auth.login');



Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/', function () {
    return view('dashboard.index');
})->name('dashboard');

Route::get('test', function () {
   return view('test');
});
