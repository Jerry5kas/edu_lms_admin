<?php

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CourseSectionController extends Controller
{
    /**
     * Display a listing of sections for a course
     */
    public function index(Course $course): JsonResponse
    {
        $sections = $course->sections()
            ->withCount('lessons')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'course' => $course,
                'sections' => $sections
            ]
        ]);
    }

    /**
     * Store a newly created section
     */
    public function store(Request $request, Course $course): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Get next sort order if not provided
        if (!$request->has('sort_order')) {
            $nextSortOrder = $course->sections()->max('sort_order') + 1;
        } else {
            $nextSortOrder = $request->sort_order;
        }

        $section = $course->sections()->create([
            'title' => $request->title,
            'sort_order' => $nextSortOrder,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Section created successfully',
            'data' => $section
        ], 201);
    }

    /**
     * Display the specified section
     */
    public function show(Course $course, CourseSection $section): JsonResponse
    {
        $section->load(['lessons' => function ($query) {
            $query->orderBy('sort_order');
        }]);

        return response()->json([
            'success' => true,
            'data' => [
                'course' => $course,
                'section' => $section
            ]
        ]);
    }

    /**
     * Update the specified section
     */
    public function update(Request $request, Course $course, CourseSection $section): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $section->update($request->only(['title', 'sort_order']));

        return response()->json([
            'success' => true,
            'message' => 'Section updated successfully',
            'data' => $section
        ]);
    }

    /**
     * Remove the specified section
     */
    public function destroy(Course $course, CourseSection $section): JsonResponse
    {
        // Check if section has lessons
        if ($section->lessons()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete section with lessons. Please remove all lessons first.'
            ], 422);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Section deleted successfully'
        ]);
    }

    /**
     * Reorder sections
     */
    public function reorder(Request $request, Course $course): JsonResponse
    {
        $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:course_sections,id',
            'sections.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->sections as $sectionData) {
            CourseSection::where('id', $sectionData['id'])
                ->where('course_id', $course->id)
                ->update(['sort_order' => $sectionData['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sections reordered successfully'
        ]);
    }

    /**
     * Get sections with lessons for API
     */
    public function getSectionsWithLessons(Course $course): JsonResponse
    {
        $sections = $course->sections()
            ->with(['lessons' => function ($query) {
                $query->orderBy('sort_order');
            }])
            ->withCount('lessons')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $sections
        ]);
    }
}
