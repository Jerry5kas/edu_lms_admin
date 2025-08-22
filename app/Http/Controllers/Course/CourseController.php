<?php

namespace App\Http\Controllers\Course;

use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     */
    public function index()
    {
        $courses = Course::with('categories')->latest()->paginate(10);

        return view('course.courses.student.index', compact('courses'));
    }

    public function instructor(){
        return view('course.courses.master.index');
    }
    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $categories = CourseCategory::orderBy('name')->get();

        return view('course.courses.student.create', compact('categories'));
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:courses,slug',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'language' => 'required|string|max:8',
            'level' => 'required|in:beginner,intermediate,advanced',
            'price_cents' => 'nullable|integer|min:0',
            'currency' => 'required|string|size:3',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'categories' => 'array',
            'thumbnail_path' => 'nullable|string',
//            'categories.*' => 'exists:course_categories,id',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            // stored in storage/app/public/thumbnails
        }

        $course = Course::create([
            'uuid' => Str::uuid(),
            'slug' => $request->slug,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'language' => $request->language,
            'level' => $request->level,
            'price_cents' => $request->price_cents ?? 0,
            'currency' => $request->currency,
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->published_at,
            'thumbnail_path' => $thumbnailPath,
            'trailer_url' => $request->trailer_url,
            'meta' => $request->meta,
            'created_by' => auth()->id(),
        ]);

        // attach categories
        if ($request->filled('categories')) {
            $course->categories()->attach($request->categories);
        }

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        $categories = CourseCategory::orderBy('name')->get();
        $selectedCategories = $course->categories->pluck('id')->toArray();

        return view('course.courses.student.edit', compact('course', 'categories', 'selectedCategories'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'slug' => 'required|unique:courses,slug,' . $course->id,
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'language' => 'required|string|max:8',
            'level' => 'required|in:beginner,intermediate,advanced',
            'price_cents' => 'nullable|integer|min:0',
            'currency' => 'required|string|size:3',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'categories' => 'array',
            'categories.*' => 'exists:course_categories,id',
        ]);

        $thumbnailPath = $course->thumbnail_path; // Keep existing thumbnail
        
        if ($request->hasFile('thumbnail')) {
            // Delete old file if exists
            if ($course->thumbnail_path && \Storage::disk('public')->exists($course->thumbnail_path)) {
                \Storage::disk('public')->delete($course->thumbnail_path);
            }

            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }
        
        $course->update([
            'slug' => $request->slug,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'language' => $request->language,
            'level' => $request->level,
            'price_cents' => $request->price_cents ?? 0,
            'currency' => $request->currency,
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->published_at,
            'thumbnail_path' => $thumbnailPath,
            'trailer_url' => $request->trailer_url,
            'meta' => $request->meta,
            'updated_by' => auth()->id(),
        ]);

        // sync categories
        $course->categories()->sync($request->categories ?? []);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
