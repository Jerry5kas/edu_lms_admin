<?php

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index(): JsonResponse
    {
        $categories = CourseCategory::withCount('courses')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:course_categories,name',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'parent_id' => 'nullable|exists:course_categories,id',
        ]);

        $data = $request->only(['name', 'description', 'sort_order', 'parent_id']);
        $data['slug'] = Str::slug($request->name);

        $category = CourseCategory::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
    }

    /**
     * Display the specified category
     */
    public function show(CourseCategory $category): JsonResponse
    {
        $category->load(['courses', 'parent', 'children']);

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, CourseCategory $category): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:course_categories,name,' . $category->id,
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'parent_id' => 'nullable|exists:course_categories,id',
        ]);

        $data = $request->only(['name', 'description', 'sort_order', 'parent_id']);
        $data['slug'] = Str::slug($request->name);

        $category->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }

    /**
     * Remove the specified category
     */
    public function destroy(CourseCategory $category): JsonResponse
    {
        // Check if category has courses
        if ($category->courses()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete category with associated courses'
            ], 422);
        }

        // Check if category has children
        if ($category->children()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete category with subcategories'
            ], 422);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}
