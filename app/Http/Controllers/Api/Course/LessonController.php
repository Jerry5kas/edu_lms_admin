<?php

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    /**
     * Display a listing of lessons for a section
     */
    public function index(Course $course, CourseSection $section): JsonResponse
    {
        $lessons = $section->lessons()
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'course' => $course,
                'section' => $section,
                'lessons' => $lessons
            ]
        ]);
    }

    /**
     * Store a newly created lesson
     */
    public function store(Request $request, Course $course, CourseSection $section): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'content_type' => 'required|in:video,text,file',
            'duration_minutes' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'video_provider' => 'nullable|string|max:50',
            'video_ref' => 'nullable|string|max:255',
            'attachment_json' => 'nullable|json',
        ]);

        // Get next sort order if not provided
        if (!$request->has('sort_order')) {
            $nextSortOrder = $section->lessons()->max('sort_order') + 1;
        } else {
            $nextSortOrder = $request->sort_order;
        }

        $lesson = $section->lessons()->create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'content_type' => $request->content_type,
            'duration_minutes' => $request->duration_minutes ?? 0,
            'sort_order' => $nextSortOrder,
            'video_provider' => $request->video_provider,
            'video_ref' => $request->video_ref,
            'attachment_json' => $request->attachment_json,
            'is_published' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lesson created successfully',
            'data' => $lesson
        ], 201);
    }

    /**
     * Display the specified lesson
     */
    public function show(Course $course, CourseSection $section, Lesson $lesson): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'course' => $course,
                'section' => $section,
                'lesson' => $lesson
            ]
        ]);
    }

    /**
     * Update the specified lesson
     */
    public function update(Request $request, Course $course, CourseSection $section, Lesson $lesson): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'content_type' => 'required|in:video,text,file',
            'duration_minutes' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'video_provider' => 'nullable|string|max:50',
            'video_ref' => 'nullable|string|max:255',
            'attachment_json' => 'nullable|json',
        ]);

        $data = $request->only([
            'title', 'content', 'content_type', 'duration_minutes', 'sort_order',
            'video_provider', 'video_ref', 'attachment_json'
        ]);
        $data['slug'] = Str::slug($request->title);

        $lesson->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Lesson updated successfully',
            'data' => $lesson
        ]);
    }

    /**
     * Remove the specified lesson
     */
    public function destroy(Course $course, CourseSection $section, Lesson $lesson): JsonResponse
    {
        $lesson->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lesson deleted successfully'
        ]);
    }

    /**
     * Publish a lesson
     */
    public function publish(Course $course, CourseSection $section, Lesson $lesson): JsonResponse
    {
        $lesson->update([
            'is_published' => true,
            'published_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lesson published successfully',
            'data' => $lesson
        ]);
    }

    /**
     * Unpublish a lesson
     */
    public function unpublish(Course $course, CourseSection $section, Lesson $lesson): JsonResponse
    {
        $lesson->update([
            'is_published' => false,
            'published_at' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lesson unpublished successfully',
            'data' => $lesson
        ]);
    }

    /**
     * Reorder lessons
     */
    public function reorder(Request $request, Course $course, CourseSection $section): JsonResponse
    {
        $request->validate([
            'lessons' => 'required|array',
            'lessons.*.id' => 'required|exists:lessons,id',
            'lessons.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->lessons as $lessonData) {
            Lesson::where('id', $lessonData['id'])
                ->where('course_section_id', $section->id)
                ->update(['sort_order' => $lessonData['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lessons reordered successfully'
        ]);
    }
}
