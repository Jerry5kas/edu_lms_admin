<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\CourseTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = CourseTag::withCount('courses')->orderBy('name')->get();
        return view('course.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('course.tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:course_tags,name',
        ]);

        CourseTag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('tags.index')->with('success', 'Tag created successfully.');
    }

    public function edit(CourseTag $tag)
    {
        return view('course.tags.edit', compact('tag'));
    }

    public function update(Request $request, CourseTag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:course_tags,name,' . $tag->id,
        ]);

        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('tags.index')->with('success', 'Tag updated successfully.');
    }

    public function destroy(CourseTag $tag)
    {
        $tag->delete();
        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully.');
    }
}
