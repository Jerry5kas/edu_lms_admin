<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::with('parent')->orderBy('sort_order')->get();
        return view('course.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = CourseCategory::all();
        return view('course.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:course_categories,slug',
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:course_categories,id',
            'sort_order' => 'nullable|integer',
        ]);

        CourseCategory::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(CourseCategory $category)
    {
        $parents = CourseCategory::where('id', '!=', $category->id)->get();
        return view('course.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, CourseCategory $category)
    {
        $request->validate([
            'slug' => 'required|unique:course_categories,slug,' . $category->id,
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:course_categories,id',
            'sort_order' => 'nullable|integer',
        ]);

        $category->update($request->all());

        return redirect()->route('course.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(CourseCategory $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
