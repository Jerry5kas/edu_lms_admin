<?php

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class QuizController extends Controller
{
    /**
     * Display a listing of quizzes
     */
    public function index(): JsonResponse
    {
        $quizzes = Quiz::with(['lesson.courseSection.course'])
            ->latest()
            ->paginate(15);

        $stats = [
            'total_quizzes' => Quiz::count(),
            'active_quizzes' => Quiz::where('is_active', true)->count(),
            'inactive_quizzes' => Quiz::where('is_active', false)->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'quizzes' => $quizzes
            ]
        ]);
    }

    /**
     * Store a newly created quiz
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lesson_id' => 'required|exists:lessons,id',
            'time_limit_minutes' => 'nullable|integer|min:1',
            'passing_score' => 'nullable|integer|min:0|max:100',
            'max_attempts' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'settings' => 'nullable|json',
        ]);

        $quiz = Quiz::create([
            'title' => $request->title,
            'description' => $request->description,
            'lesson_id' => $request->lesson_id,
            'time_limit_minutes' => $request->time_limit_minutes,
            'passing_score' => $request->passing_score,
            'max_attempts' => $request->max_attempts,
            'is_active' => $request->is_active ?? true,
            'settings' => $request->settings ? json_decode($request->settings, true) : [],
        ]);

        $quiz->load('lesson.courseSection.course');

        return response()->json([
            'success' => true,
            'message' => 'Quiz created successfully',
            'data' => $quiz
        ], 201);
    }

    /**
     * Display the specified quiz
     */
    public function show(Quiz $quiz): JsonResponse
    {
        $quiz->load('lesson.courseSection.course');

        return response()->json([
            'success' => true,
            'data' => $quiz
        ]);
    }

    /**
     * Update the specified quiz
     */
    public function update(Request $request, Quiz $quiz): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lesson_id' => 'required|exists:lessons,id',
            'time_limit_minutes' => 'nullable|integer|min:1',
            'passing_score' => 'nullable|integer|min:0|max:100',
            'max_attempts' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'settings' => 'nullable|json',
        ]);

        $quiz->update([
            'title' => $request->title,
            'description' => $request->description,
            'lesson_id' => $request->lesson_id,
            'time_limit_minutes' => $request->time_limit_minutes,
            'passing_score' => $request->passing_score,
            'max_attempts' => $request->max_attempts,
            'is_active' => $request->is_active,
            'settings' => $request->settings ? json_decode($request->settings, true) : $quiz->settings,
        ]);

        $quiz->load('lesson.courseSection.course');

        return response()->json([
            'success' => true,
            'message' => 'Quiz updated successfully',
            'data' => $quiz
        ]);
    }

    /**
     * Remove the specified quiz
     */
    public function destroy(Quiz $quiz): JsonResponse
    {
        $quiz->delete();

        return response()->json([
            'success' => true,
            'message' => 'Quiz deleted successfully'
        ]);
    }

    /**
     * Toggle quiz active status
     */
    public function toggleActive(Quiz $quiz): JsonResponse
    {
        $quiz->update([
            'is_active' => !$quiz->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quiz ' . ($quiz->is_active ? 'activated' : 'deactivated') . ' successfully',
            'data' => $quiz
        ]);
    }

    /**
     * Get quizzes for a specific lesson
     */
    public function getQuizzesForLesson(Lesson $lesson): JsonResponse
    {
        $quizzes = Quiz::where('lesson_id', $lesson->id)
            ->where('is_active', true)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'lesson' => $lesson,
                'quizzes' => $quizzes
            ]
        ]);
    }
}
