<?php

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonView;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LessonViewController extends Controller
{
    /**
     * Display a listing of lesson views (admin overview)
     */
    public function index(): JsonResponse
    {
        $lessonViews = LessonView::with(['user', 'lesson.courseSection.course'])
            ->latest()
            ->paginate(20);

        $stats = [
            'total_views' => LessonView::count(),
            'completed_lessons' => LessonView::whereNotNull('completed_at')->count(),
            'in_progress' => LessonView::whereNull('completed_at')->where('seconds_watched', '>', 0)->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'lesson_views' => $lessonViews
            ]
        ]);
    }

    /**
     * Display the specified lesson view
     */
    public function show(LessonView $lessonView): JsonResponse
    {
        $lessonView->load(['user', 'lesson.courseSection.course']);

        return response()->json([
            'success' => true,
            'data' => $lessonView
        ]);
    }

    /**
     * Start a lesson (create lesson view record)
     */
    public function startLesson(Request $request, Lesson $lesson): JsonResponse
    {
        $user = Auth::user();

        // Check if lesson view already exists
        $lessonView = LessonView::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        if (!$lessonView) {
            // Create new lesson view
            $lessonView = LessonView::create([
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
                'last_position_seconds' => 0,
                'seconds_watched' => 0,
                'started_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lesson started successfully',
            'data' => $lessonView
        ]);
    }

    /**
     * Track lesson progress
     */
    public function trackProgress(Request $request, Lesson $lesson): JsonResponse
    {
        $request->validate([
            'position_seconds' => 'required|integer|min:0',
            'total_seconds' => 'required|integer|min:0',
        ]);

        $user = Auth::user();

        $lessonView = LessonView::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        if (!$lessonView) {
            return response()->json([
                'success' => false,
                'message' => 'Lesson not started. Please start the lesson first.'
            ], 400);
        }

        // Calculate progress percentage
        $progressPercentage = ($request->position_seconds / $request->total_seconds) * 100;

        // Update lesson view
        $lessonView->update([
            'last_position_seconds' => $request->position_seconds,
            'seconds_watched' => $request->position_seconds,
            'progress_percentage' => $progressPercentage,
            'last_activity_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Progress tracked successfully',
            'data' => $lessonView
        ]);
    }

    /**
     * Complete a lesson
     */
    public function completeLesson(Request $request, Lesson $lesson): JsonResponse
    {
        $user = Auth::user();

        $lessonView = LessonView::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        if (!$lessonView) {
            return response()->json([
                'success' => false,
                'message' => 'Lesson not started. Please start the lesson first.'
            ], 400);
        }

        $lessonView->update([
            'completed_at' => now(),
            'progress_percentage' => 100,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lesson completed successfully',
            'data' => $lessonView
        ]);
    }

    /**
     * Get progress for a specific lesson
     */
    public function getProgress(Lesson $lesson): JsonResponse
    {
        $user = Auth::user();

        $lessonView = LessonView::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        return response()->json([
            'success' => true,
            'data' => $lessonView
        ]);
    }

    /**
     * Get course progress
     */
    public function getCourseProgress(Course $course): JsonResponse
    {
        $user = Auth::user();

        $lessonViews = LessonView::where('user_id', $user->id)
            ->whereHas('lesson.courseSection', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->with(['lesson.courseSection'])
            ->get();

        $totalLessons = $course->lessons()->count();
        $completedLessons = $lessonViews->whereNotNull('completed_at')->count();
        $progressPercentage = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'course' => $course,
                'total_lessons' => $totalLessons,
                'completed_lessons' => $completedLessons,
                'progress_percentage' => $progressPercentage,
                'lesson_views' => $lessonViews
            ]
        ]);
    }

    /**
     * Get lesson progress view (admin)
     */
    public function lessonProgress(Lesson $lesson): JsonResponse
    {
        $lessonViews = LessonView::where('lesson_id', $lesson->id)
            ->with('user')
            ->get();

        $stats = [
            'total_views' => $lessonViews->count(),
            'completed' => $lessonViews->whereNotNull('completed_at')->count(),
            'in_progress' => $lessonViews->whereNull('completed_at')->where('seconds_watched', '>', 0)->count(),
            'not_started' => $lessonViews->where('seconds_watched', 0)->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'lesson' => $lesson,
                'stats' => $stats,
                'lesson_views' => $lessonViews
            ]
        ]);
    }

    /**
     * Get user lesson progress (admin)
     */
    public function userProgress(User $user): JsonResponse
    {
        $lessonViews = LessonView::where('user_id', $user->id)
            ->with(['lesson.courseSection.course'])
            ->get();

        $stats = [
            'total_lessons_started' => $lessonViews->count(),
            'completed_lessons' => $lessonViews->whereNotNull('completed_at')->count(),
            'in_progress' => $lessonViews->whereNull('completed_at')->where('seconds_watched', '>', 0)->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'stats' => $stats,
                'lesson_views' => $lessonViews
            ]
        ]);
    }

    /**
     * Get course progress view (admin)
     */
    public function courseProgress(Course $course): JsonResponse
    {
        $lessonViews = LessonView::whereHas('lesson.courseSection', function ($query) use ($course) {
            $query->where('course_id', $course->id);
        })
        ->with(['user', 'lesson.courseSection'])
        ->get();

        $stats = [
            'total_lesson_views' => $lessonViews->count(),
            'unique_users' => $lessonViews->unique('user_id')->count(),
            'completed_lessons' => $lessonViews->whereNotNull('completed_at')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'course' => $course,
                'stats' => $stats,
                'lesson_views' => $lessonViews
            ]
        ]);
    }
}
