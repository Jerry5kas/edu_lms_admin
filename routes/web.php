<?php
use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\CategoryController;
use App\Http\Controllers\Course\TagController;
use App\Http\Controllers\Course\CourseSectionController;
use App\Http\Controllers\Course\LessonController;
use App\Http\Controllers\Course\LessonViewController;
use App\Http\Controllers\Course\QuizController;
use App\Http\Controllers\Course\MediaController;
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
use App\Http\Controllers\SubscriptionPlanController;

Route::get('/notifications', function () {
    return view('notification.index');
})->name('notifications.index');

Route::get('/notifications/create', function () {
    return view('notification.create');
})->name('notifications.create');

Route::get('/notifications/edit', function () {
    return view('notification.edit');
})->name('notifications.edit');


Route::resource('/subscriptions', SubscriptionPlanController::class);

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

    // Lesson Views - Progress Tracking
    Route::get('/lesson-views', [LessonViewController::class, 'index'])->name('lesson-views.index');
    Route::get('/lesson-views/{lessonView}', [LessonViewController::class, 'show'])->name('lesson-views.show');

    // Lesson Progress Tracking (AJAX endpoints)
    Route::post('/lessons/{lesson}/start', [LessonViewController::class, 'startLesson'])->name('lessons.start');
    Route::post('/lessons/{lesson}/track-progress', [LessonViewController::class, 'trackProgress'])->name('lessons.track-progress');
    Route::post('/lessons/{lesson}/complete', [LessonViewController::class, 'completeLesson'])->name('lessons.complete');
    Route::get('/lessons/{lesson}/progress', [LessonViewController::class, 'getProgress'])->name('lessons.get-progress');
    Route::get('/courses/{course}/progress', [LessonViewController::class, 'getCourseProgress'])->name('courses.progress');

    // Admin Progress Views
    Route::get('/lessons/{lesson}/progress-view', [LessonViewController::class, 'lessonProgress'])->name('lessons.progress-view');
    Route::get('/users/{user}/lesson-progress', [LessonViewController::class, 'userProgress'])->name('users.lesson-progress');
    Route::get('/courses/{course}/progress-view', [LessonViewController::class, 'courseProgress'])->name('courses.progress-view');

    // Tracking Example
    Route::get('/lesson-tracking-example', function() {
        return view('course.courses.lesson-view.tracking-example');
    })->name('lesson-tracking.example');

    Route::resource('/categories', CategoryController::class);
    Route::resource('/tags', TagController::class);


    // Quizzes
    Route::resource('/quizzes', QuizController::class);
    Route::patch('/quizzes/{quiz}/toggle-active', [QuizController::class, 'toggleActive'])->name('quizzes.toggle-active');
    Route::get('/lessons/{lesson}/quizzes', [QuizController::class, 'getQuizzesForLesson'])->name('lessons.quizzes');

    // Media Management
    Route::resource('/media', MediaController::class);
    Route::post('/media/upload', [MediaController::class, 'upload'])->name('media.upload');
    Route::get('/media/get-media', [MediaController::class, 'getMedia'])->name('media.get-media');
    Route::post('/media/get-by-path', [MediaController::class, 'getByPath'])->name('media.get-by-path');
    Route::post('/media/bulk-delete', [MediaController::class, 'bulkDelete'])->name('media.bulk-delete');
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [WebAuthController::class, 'dashboard'])->name('dashboard.index');
});

Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::get('/test', function () {
    return view('test');
});

use App\Http\Controllers\PaymentController;

Route::resource('payments', PaymentController::class);
use App\Http\Controllers\EnrollmentController;

Route::middleware(['auth'])->group(function () {
    // Enroll a user into a course
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('courses.enroll');

    // List my enrolled courses
    Route::get('/my-courses', [EnrollmentController::class, 'index'])->name('my.courses');
});
