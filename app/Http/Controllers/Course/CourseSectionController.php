<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use Illuminate\Http\Request;

class CourseSectionController extends Controller
{
    /**
     * Display sections for a specific course
     */
    public function index(Course $course)
    {
        $sections = $course->sections()->with('lessons')->orderBy('sort_order')->get();
        return view('course.courses.sections.index', compact('course', 'sections'));
    }

    /**
     * Show the form for creating a new section
     */
    public function create(Course $course)
    {
        $nextSortOrder = $course->sections()->max('sort_order') + 1;
        return view('course.courses.sections.create', compact('course', 'nextSortOrder'));
    }

    /**
     * Store a newly created section
     */
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $course->sections()->create([
            'title' => $request->title,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('courses.sections.index', $course)
            ->with('success', 'Section created successfully.');
    }

    /**
     * Show the form for editing the specified section
     */
    public function edit(Course $course, CourseSection $section)
    {
        return view('course.courses.sections.edit', compact('course', 'section'));
    }

    /**
     * Update the specified section
     */
    public function update(Request $request, Course $course, CourseSection $section)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $section->update([
            'title' => $request->title,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('courses.sections.index', $course)
            ->with('success', 'Section updated successfully.');
    }

    /**
     * Remove the specified section
     */
    public function destroy(Course $course, CourseSection $section)
    {
        $section->delete();
        
        return redirect()->route('courses.sections.index', $course)
            ->with('success', 'Section deleted successfully.');
    }

    /**
     * Reorder sections (AJAX endpoint)
     */
    public function reorder(Request $request, Course $course)
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

        return response()->json(['message' => 'Sections reordered successfully']);
    }

    /**
     * Get sections with lessons for a course (API endpoint)
     */
    public function getSectionsWithLessons(Course $course)
    {
        $sections = $course->sections()
            ->with(['lessons' => function($query) {
                $query->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        return response()->json($sections);
    }
}
