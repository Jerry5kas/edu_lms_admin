<?php
use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\CategoryController;
use App\Http\Controllers\Course\TagController;
use App\Http\Controllers\Course\CourseSectionController;
use App\Http\Controllers\Course\LessonController;
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
    Route::patch('/courses/{course}/publish', [CourseController::class, 'publish'])->name('courses.publish');
    Route::patch('/courses/{course}/unpublish', [CourseController::class, 'unpublish'])->name('courses.unpublish');
    Route::get('/instructor', [CourseController::class, 'instructor'])->name('instructor.courses.index');

    // Course Sections
    Route::resource('/courses.sections', CourseSectionController::class);
    Route::post('/courses/{course}/sections/reorder', [CourseSectionController::class, 'reorder'])->name('courses.sections.reorder');
    Route::get('/courses/{course}/sections/api', [CourseSectionController::class, 'getSectionsWithLessons'])->name('courses.sections.api');

    // Lessons
    Route::resource('/courses.sections.lessons', LessonController::class);
    Route::patch('/courses/{course}/sections/{section}/lessons/{lesson}/publish', [LessonController::class, 'publish'])->name('courses.sections.lessons.publish');
    Route::patch('/courses/{course}/sections/{section}/lessons/{lesson}/unpublish', [LessonController::class, 'unpublish'])->name('courses.sections.lessons.unpublish');
    Route::post('/courses/{course}/sections/{section}/lessons/reorder', [LessonController::class, 'reorder'])->name('courses.sections.lessons.reorder');

    Route::resource('/categories', CategoryController::class);
    Route::resource('/tags', TagController::class);
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [WebAuthController::class, 'dashboard'])->name('dashboard.index');
});

Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::get('/test', function () {
    return view('test');
});

