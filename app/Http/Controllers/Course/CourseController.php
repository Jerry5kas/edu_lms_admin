<?php

namespace App\Http\Controllers\Course;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseTag;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     */
    public function index()
    {
        $courses = Course::with('categories', 'tags')->latest()->paginate(10);
        return view('course.courses.all courses.index', compact('courses'));
    }

    public function instructor(){
        return view('course.courses.master.index');
    }
    /**
     * Display the specified course.
     */
    public function show(Course $course)
    {
        $course->load(['categories', 'tags', 'sections.lessons', 'creator']);
        return view('course.courses.all courses.show', compact('course'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $categories = CourseCategory::all();
        $tags = CourseTag::all();
        return view('course.courses.all courses.create', compact('categories','tags'));
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
            'categories.*' => 'exists:course_categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:course_tags,id',
            'thumbnail_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $thumbnailPath = null;
        $mediaId = null;

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $thumbnailPath = $file->store('thumbnails', 'public');

            // Create media record
            $media = Media::create([
                'user_id' => auth()->id(),
                'disk' => 'public',
                'path' => $thumbnailPath,
                'mime' => $file->getMimeType(),
                'size_bytes' => $file->getSize(),
                'original_name' => $file->getClientOriginalName(),
                'meta' => [
                    'width' => getimagesize($file->getPathname())[0] ?? null,
                    'height' => getimagesize($file->getPathname())[1] ?? null,
                ]
            ]);
            $mediaId = $media->id;
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
            'published_at' => $request->boolean('is_published') ? now() : null,
            'thumbnail_path' => $thumbnailPath,
            'trailer_url' => $request->trailer_url,
            'meta' => $request->meta,
            'created_by' => auth()->id(),
        ]);

        // Attach categories
        if ($request->filled('categories')) {
            $course->categories()->attach($request->categories);
        }

        // Attach tags
        if ($request->filled('tags')) {
            $course->tags()->attach($request->tags);
        }

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        $categories = CourseCategory::all();
        $tags = CourseTag::all();
        $selectedCategories = $course->categories->pluck('id')->toArray();
        $selectedTags = $course->tags->pluck('id')->toArray();
        $sections = $course->sections()->with('lessons')->orderBy('sort_order')->get();

        return view('course.courses.all courses.edit', compact('course', 'categories', 'tags', 'selectedCategories', 'selectedTags', 'sections'));
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
            'tags' => 'array',
            'tags.*' => 'exists:course_tags,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $thumbnailPath = $course->thumbnail_path; // Keep existing thumbnail

        if ($request->hasFile('thumbnail')) {
            // Delete old file if exists
            if ($course->thumbnail_path && Storage::disk('public')->exists($course->thumbnail_path)) {
                Storage::disk('public')->delete($course->thumbnail_path);
            }

            $file = $request->file('thumbnail');
            $thumbnailPath = $file->store('thumbnails', 'public');

            // Create media record
            Media::create([
                'user_id' => auth()->id(),
                'disk' => 'public',
                'path' => $thumbnailPath,
                'mime' => $file->getMimeType(),
                'size_bytes' => $file->getSize(),
                'original_name' => $file->getClientOriginalName(),
                'meta' => [
                    'width' => getimagesize($file->getPathname())[0] ?? null,
                    'height' => getimagesize($file->getPathname())[1] ?? null,
                ]
            ]);
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
            'published_at' => $request->boolean('is_published') ? ($course->published_at ?? now()) : null,
            'thumbnail_path' => $thumbnailPath,
            'trailer_url' => $request->trailer_url,
            'meta' => $request->meta,
            'updated_by' => auth()->id(),
        ]);

        // Sync categories
        $course->categories()->sync($request->categories ?? []);

        // Sync tags
        $course->tags()->sync($request->tags ?? []);

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

    /**
     * Publish the specified course.
     */
    public function publish(Course $course)
    {
        $course->update([
            'is_published' => true,
            'published_at' => now(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('courses.index')->with('success', 'Course published successfully.');
    }

    /**
     * Unpublish the specified course.
     */
    public function unpublish(Course $course)
    {
        $course->update([
            'is_published' => false,
            'published_at' => null,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('courses.index')->with('success', 'Course unpublished successfully.');
    }
}
