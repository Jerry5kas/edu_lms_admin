<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\LessonView;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonViewController extends Controller
{
    /**
     * Display a listing of the lesson views
     */
    public function index()
    {
        $lessonViews = LessonView::with(['user', 'lesson.course'])
            ->latest()
            ->paginate(15);
        
        return view('course.courses.lesson-view.index', compact('lessonViews'));
    }

    /**
     * Display the specified lesson view
     */
    public function show(LessonView $lessonView)
    {
        $lessonView->load(['user', 'lesson.course']);
        return view('course.courses.lesson-view.show', compact('lessonView'));
    }

    /**
     * Start a lesson - Create lesson view entry when user starts a lesson
     */
    public function startLesson(Request $request, Lesson $lesson)
    {
        $user = Auth::user();
        
        // Create lesson view entry if it doesn't exist
        $lessonView = LessonView::firstOrCreate(
            [
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
            ],
            [
                'seconds_watched' => 0,
                'last_position_seconds' => 0,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Lesson started successfully',
            'lesson_view_id' => $lessonView->id,
        ]);
    }

    /**
     * Track lesson progress (AJAX endpoint) - Update while watching/reading
     */
    public function trackProgress(Request $request, Lesson $lesson)
    {
        $request->validate([
            'seconds_watched' => 'required|integer|min:0',
            'last_position_seconds' => 'required|integer|min:0',
            'is_completed' => 'boolean',
        ]);

        $user = Auth::user();
        
        // Find or create lesson view
        $lessonView = LessonView::firstOrCreate(
            [
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
            ],
            [
                'seconds_watched' => 0,
                'last_position_seconds' => 0,
            ]
        );

        // Update progress
        $lessonView->update([
            'seconds_watched' => $request->seconds_watched,
            'last_position_seconds' => $request->last_position_seconds,
            'completed_at' => $request->is_completed ? now() : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Progress tracked successfully',
            'progress' => $this->calculateProgress($lessonView),
            'is_completed' => !is_null($lessonView->completed_at),
        ]);
    }

    /**
     * Complete a lesson - Set completed_at timestamp
     */
    public function completeLesson(Request $request, Lesson $lesson)
    {
        $user = Auth::user();
        
        $lessonView = LessonView::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        if (!$lessonView) {
            return response()->json([
                'success' => false,
                'message' => 'Lesson view not found',
            ], 404);
        }

        $lessonView->update([
            'completed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lesson completed successfully',
            'progress' => $this->calculateProgress($lessonView),
        ]);
    }

    /**
     * Get lesson progress for current user
     */
    public function getProgress(Lesson $lesson)
    {
        $user = Auth::user();
        $lessonView = LessonView::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        if (!$lessonView) {
            return response()->json([
                'progress' => 0,
                'seconds_watched' => 0,
                'last_position_seconds' => 0,
                'is_completed' => false,
                'has_started' => false,
            ]);
        }

        return response()->json([
            'progress' => $this->calculateProgress($lessonView),
            'seconds_watched' => $lessonView->seconds_watched,
            'last_position_seconds' => $lessonView->last_position_seconds,
            'is_completed' => !is_null($lessonView->completed_at),
            'completed_at' => $lessonView->completed_at,
            'has_started' => true,
        ]);
    }

    /**
     * Get course progress for current user
     */
    public function getCourseProgress(Course $course)
    {
        $user = Auth::user();
        
        // Get all lessons in the course
        $totalLessons = $course->lessons()->count();
        
        if ($totalLessons === 0) {
            return response()->json([
                'progress' => 0,
                'completed_lessons' => 0,
                'total_lessons' => 0,
            ]);
        }

        // Get completed lessons
        $completedLessons = LessonView::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->whereHas('lesson', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->count();

        $progress = ($completedLessons / $totalLessons) * 100;

        return response()->json([
            'progress' => round($progress, 1),
            'completed_lessons' => $completedLessons,
            'total_lessons' => $totalLessons,
        ]);
    }

    /**
     * Calculate progress percentage for a lesson
     */
    private function calculateProgress(LessonView $lessonView)
    {
        if ($lessonView->lesson->duration_seconds <= 0) {
            return 0;
        }

        return min(100, ($lessonView->seconds_watched / $lessonView->lesson->duration_seconds) * 100);
    }

    /**
     * Get all lesson views for a specific lesson (admin view)
     */
    public function lessonProgress(Lesson $lesson)
    {
        $lessonViews = LessonView::where('lesson_id', $lesson->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('course.courses.lesson-view.lesson-progress', compact('lesson', 'lessonViews'));
    }

    /**
     * Get all lesson views for a specific user (admin view)
     */
    public function userProgress(User $user)
    {
        $lessonViews = LessonView::where('user_id', $user->id)
            ->with(['lesson.course'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('course.courses.lesson-view.user-progress', compact('user', 'lessonViews'));
    }

    /**
     * Get course progress overview for admin
     */
    public function courseProgress(Course $course)
    {
        $totalStudents = User::count(); // You might want to filter by enrolled students
        $totalLessons = $course->lessons()->count();
        
        $lessonViews = LessonView::whereHas('lesson', function ($query) use ($course) {
            $query->where('course_id', $course->id);
        })
        ->with(['user', 'lesson'])
        ->orderBy('created_at', 'desc')
        ->paginate(15);

        $stats = [
            'total_students' => $totalStudents,
            'total_lessons' => $totalLessons,
            'total_views' => $lessonViews->total(),
            'completed_views' => LessonView::whereHas('lesson', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })->whereNotNull('completed_at')->count(),
        ];

        return view('course.courses.lesson-view.course-progress', compact('course', 'lessonViews', 'stats'));
    }
}
