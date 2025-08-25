<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Display a listing of quizzes
     */
    public function index()
    {
        $quizzes = Quiz::with(['lesson.course'])
            ->latest()
            ->paginate(15);
        
        return view('course.quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new quiz
     */
    public function create()
    {
        $lessons = Lesson::with('course')
            ->where('is_published', true)
            ->orderBy('title')
            ->get();
        
        return view('course.quizzes.create', compact('lessons'));
    }

    /**
     * Store a newly created quiz
     */
    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'nullable|integer|min:1',
            'passing_score' => 'nullable|integer|min:0|max:100',
            'max_attempts' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $quiz = Quiz::create([
            'lesson_id' => $request->lesson_id,
            'title' => $request->title,
            'description' => $request->description,
            'settings' => [
                'time_limit' => $request->time_limit,
                'passing_score' => $request->passing_score,
                'max_attempts' => $request->max_attempts,
                'is_active' => $request->boolean('is_active', true),
                'shuffle_questions' => $request->boolean('shuffle_questions', false),
                'show_results' => $request->boolean('show_results', true),
                'allow_review' => $request->boolean('allow_review', true),
            ],
        ]);

        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz created successfully.');
    }

    /**
     * Display the specified quiz
     */
    public function show(Quiz $quiz)
    {
        $quiz->load(['lesson.course']);
        return view('course.quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified quiz
     */
    public function edit(Quiz $quiz)
    {
        $lessons = Lesson::with('course')
            ->where('is_published', true)
            ->orderBy('title')
            ->get();
        
        return view('course.quizzes.edit', compact('quiz', 'lessons'));
    }

    /**
     * Update the specified quiz
     */
    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'nullable|integer|min:1',
            'passing_score' => 'nullable|integer|min:0|max:100',
            'max_attempts' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $quiz->update([
            'lesson_id' => $request->lesson_id,
            'title' => $request->title,
            'description' => $request->description,
            'settings' => [
                'time_limit' => $request->time_limit,
                'passing_score' => $request->passing_score,
                'max_attempts' => $request->max_attempts,
                'is_active' => $request->boolean('is_active', true),
                'shuffle_questions' => $request->boolean('shuffle_questions', false),
                'show_results' => $request->boolean('show_results', true),
                'allow_review' => $request->boolean('allow_review', true),
            ],
        ]);

        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified quiz
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        
        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz deleted successfully.');
    }

    /**
     * Toggle quiz active status
     */
    public function toggleActive(Quiz $quiz)
    {
        $settings = $quiz->settings;
        $settings['is_active'] = !($settings['is_active'] ?? true);
        $quiz->update(['settings' => $settings]);

        $status = $settings['is_active'] ? 'activated' : 'deactivated';
        
        return redirect()->route('quizzes.index')
            ->with('success', "Quiz {$status} successfully.");
    }

    /**
     * Get quizzes for a specific lesson
     */
    public function getQuizzesForLesson(Lesson $lesson)
    {
        $quizzes = Quiz::where('lesson_id', $lesson->id)
            ->where('settings->is_active', true)
            ->get();

        return response()->json($quizzes);
    }
}
