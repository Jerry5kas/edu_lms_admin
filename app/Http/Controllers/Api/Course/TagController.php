<?php

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Models\CourseTag;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of tags
     */
    public function index(): JsonResponse
    {
        $tags = CourseTag::withCount('courses')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tags
        ]);
    }

    /**
     * Store a newly created tag
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:course_tags,name',
        ]);

        $tag = CourseTag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tag created successfully',
            'data' => $tag
        ], 201);
    }

    /**
     * Display the specified tag
     */
    public function show(CourseTag $tag): JsonResponse
    {
        $tag->load('courses');

        return response()->json([
            'success' => true,
            'data' => $tag
        ]);
    }

    /**
     * Update the specified tag
     */
    public function update(Request $request, CourseTag $tag): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:course_tags,name,' . $tag->id,
        ]);

        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tag updated successfully',
            'data' => $tag
        ]);
    }

    /**
     * Remove the specified tag
     */
    public function destroy(CourseTag $tag): JsonResponse
    {
        $tag->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tag deleted successfully'
        ]);
    }
}
