<?php

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseTag;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of courses
     */
    public function index(): JsonResponse
    {
        $courses = Course::with(['categories', 'tags', 'creator'])
            ->withCount(['sections', 'lessons'])
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $courses
        ]);
    }

    /**
     * Store a newly created course
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:courses,slug',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:course_categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:course_tags,id',
            'thumbnail_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer_path' => 'nullable|file|mimes:mp4,avi,mov|max:10240',
        ]);

        $data = $request->only(['title', 'slug', 'description', 'price', 'category_id']);
        $data['user_id'] = Auth::id();
        $data['is_published'] = false;

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail_path')) {
            $thumbnail = $request->file('thumbnail_path');
            $thumbnailName = time() . '_' . Str::random(10) . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnailPath = $thumbnail->storeAs('course_thumbnails', $thumbnailName, 'public');
            $data['thumbnail_path'] = $thumbnailPath;
        }

        // Handle trailer upload
        if ($request->hasFile('trailer_path')) {
            $trailer = $request->file('trailer_path');
            $trailerName = time() . '_' . Str::random(10) . '.' . $trailer->getClientOriginalExtension();
            $trailerPath = $trailer->storeAs('course_trailers', $trailerName, 'public');
            $data['trailer_path'] = $trailerPath;
        }

        $course = Course::create($data);

        // Attach tags
        if ($request->has('tags')) {
            $course->tags()->attach($request->tags);
        }

        $course->load(['categories', 'tags', 'creator']);

        return response()->json([
            'success' => true,
            'message' => 'Course created successfully',
            'data' => $course
        ], 201);
    }

    /**
     * Display the specified course
     */
    public function show(Course $course): JsonResponse
    {
        $course->load(['categories', 'tags', 'sections.lessons', 'creator']);

        return response()->json([
            'success' => true,
            'data' => $course
        ]);
    }

    /**
     * Update the specified course
     */
    public function update(Request $request, Course $course): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:courses,slug,' . $course->id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:course_categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:course_tags,id',
            'thumbnail_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer_path' => 'nullable|file|mimes:mp4,avi,mov|max:10240',
        ]);

        $data = $request->only(['title', 'slug', 'description', 'price', 'category_id']);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail_path')) {
            // Delete old thumbnail
            if ($course->thumbnail_path && Storage::disk('public')->exists($course->thumbnail_path)) {
                Storage::disk('public')->delete($course->thumbnail_path);
            }

            $thumbnail = $request->file('thumbnail_path');
            $thumbnailName = time() . '_' . Str::random(10) . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnailPath = $thumbnail->storeAs('course_thumbnails', $thumbnailName, 'public');
            $data['thumbnail_path'] = $thumbnailPath;
        }

        // Handle trailer upload
        if ($request->hasFile('trailer_path')) {
            // Delete old trailer
            if ($course->trailer_path && Storage::disk('public')->exists($course->trailer_path)) {
                Storage::disk('public')->delete($course->trailer_path);
            }

            $trailer = $request->file('trailer_path');
            $trailerName = time() . '_' . Str::random(10) . '.' . $trailer->getClientOriginalExtension();
            $trailerPath = $trailer->storeAs('course_trailers', $trailerName, 'public');
            $data['trailer_path'] = $trailerPath;
        }

        $course->update($data);

        // Sync tags
        if ($request->has('tags')) {
            $course->tags()->sync($request->tags);
        }

        $course->load(['categories', 'tags', 'creator']);

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully',
            'data' => $course
        ]);
    }

    /**
     * Remove the specified course
     */
    public function destroy(Course $course): JsonResponse
    {
        // Delete associated files
        if ($course->thumbnail_path && Storage::disk('public')->exists($course->thumbnail_path)) {
            Storage::disk('public')->delete($course->thumbnail_path);
        }

        if ($course->trailer_path && Storage::disk('public')->exists($course->trailer_path)) {
            Storage::disk('public')->delete($course->trailer_path);
        }

        $course->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully'
        ]);
    }

    /**
     * Publish a course
     */
    public function publish(Course $course): JsonResponse
    {
        $course->update([
            'is_published' => true,
            'published_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course published successfully',
            'data' => $course
        ]);
    }

    /**
     * Unpublish a course
     */
    public function unpublish(Course $course): JsonResponse
    {
        $course->update([
            'is_published' => false,
            'published_at' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course unpublished successfully',
            'data' => $course
        ]);
    }

    /**
     * Get instructor courses
     */
    public function instructor(): JsonResponse
    {
        $courses = Course::where('user_id', Auth::id())
            ->with(['categories', 'tags'])
            ->withCount(['sections', 'lessons'])
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $courses
        ]);
    }

    /**
     * Get dashboard data
     */
    public function dashboard(): JsonResponse
    {
        $user = Auth::user();
        
        $stats = [
            'total_courses' => Course::where('user_id', $user->id)->count(),
            'published_courses' => Course::where('user_id', $user->id)->where('is_published', true)->count(),
            'draft_courses' => Course::where('user_id', $user->id)->where('is_published', false)->count(),
            'total_lessons' => Course::where('user_id', $user->id)->withCount('lessons')->get()->sum('lessons_count'),
        ];

        $recent_courses = Course::where('user_id', $user->id)
            ->with(['categories', 'tags'])
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'recent_courses' => $recent_courses
            ]
        ]);
    }
}
