<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Lesson;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    /**
     * Display lessons for a specific section
     */
    public function index(Course $course, CourseSection $section)
    {
        $lessons = $section->lessons()->orderBy('sort_order')->get();
        return view('course.courses.lessons.index', compact('course', 'section', 'lessons'));
    }

    /**
     * Show the form for creating a new lesson
     */
    public function create(Course $course, CourseSection $section)
    {
        return view('course.courses.lessons.create', compact('course', 'section'));
    }

    /**
     * Store a newly created lesson
     */
    public function store(Request $request, Course $course, CourseSection $section)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content_type' => 'required|in:text,video,pdf,file',
            'content' => 'nullable|string',
            'video_provider' => 'nullable|string|max:100',
            'video_ref' => 'nullable|string|max:255',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt|max:10240',
            'sort_order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
        ]);

        $lessonData = [
            'course_id' => $course->id,
            'section_id' => $section->id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content_type' => $request->content_type,
//            'content' => $request->content,
            'sort_order' => $request->sort_order ?? 0,
            'is_published' => $request->boolean('is_published'),
            'created_by' => auth()->id(),
        ];

        // Handle video lessons
        if ($request->content_type === 'video') {
            $lessonData['video_provider'] = $request->video_provider;
            $lessonData['video_ref'] = $request->video_ref;
        }

        // Handle file attachments
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('lessons/attachments', 'public');

            $media = Media::create([
                'user_id' => auth()->id(),
                'disk' => 'public',
                'path' => $path,
                'mime' => $file->getMimeType(),
                'size_bytes' => $file->getSize(),
                'original_name' => $file->getClientOriginalName(),
            ]);

            $lessonData['attachment_json'] = json_encode([
                'media_id' => $media->id,
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
            ]);
        }

        $lesson = Lesson::create($lessonData);

        return redirect()->route('courses.sections.lessons.index', [$course, $section])
            ->with('success', 'Lesson created successfully.');
    }

    /**
     * Show the form for editing the specified lesson
     */
    public function edit(Course $course, CourseSection $section, Lesson $lesson)
    {
        return view('course.courses.lessons.edit', compact('course', 'section', 'lesson'));
    }

    /**
     * Update the specified lesson
     */
    public function update(Request $request, Course $course, CourseSection $section, Lesson $lesson)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content_type' => 'required|in:text,video,pdf,file',
            'content' => 'nullable|string',
            'video_provider' => 'nullable|string|max:100',
            'video_ref' => 'nullable|string|max:255',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt|max:10240',
            'sort_order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
        ]);

        $lessonData = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content_type' => $request->content_type,
//            'content' => $request->content,
            'sort_order' => $request->sort_order ?? 0,
            'is_published' => $request->boolean('is_published'),
            'updated_by' => auth()->id(),
        ];

        // Handle video lessons
        if ($request->content_type === 'video') {
            $lessonData['video_provider'] = $request->video_provider;
            $lessonData['video_ref'] = $request->video_ref;
        }

        // Handle file attachments
        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($lesson->attachment_json) {
                $oldAttachment = json_decode($lesson->attachment_json, true);
                if (isset($oldAttachment['media_id'])) {
                    Media::find($oldAttachment['media_id'])->delete();
                }
            }

            $file = $request->file('attachment');
            $path = $file->store('lessons/attachments', 'public');

            $media = Media::create([
                'user_id' => auth()->id(),
                'disk' => 'public',
                'path' => $path,
                'mime' => $file->getMimeType(),
                'size_bytes' => $file->getSize(),
                'original_name' => $file->getClientOriginalName(),
            ]);

            $lessonData['attachment_json'] = json_encode([
                'media_id' => $media->id,
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
            ]);
        }

        $lesson->update($lessonData);

        return redirect()->route('courses.sections.lessons.index', [$course, $section])
            ->with('success', 'Lesson updated successfully.');
    }

    /**
     * Remove the specified lesson
     */
    public function destroy(Course $course, CourseSection $section, Lesson $lesson)
    {
        // Delete associated media if exists
        if ($lesson->attachment_json) {
            $attachment = json_decode($lesson->attachment_json, true);
            if (isset($attachment['media_id'])) {
                Media::find($attachment['media_id'])->delete();
            }
        }

        $lesson->delete();

        return redirect()->route('courses.sections.lessons.index', [$course, $section])
            ->with('success', 'Lesson deleted successfully.');
    }

    /**
     * Publish the specified lesson
     */
    public function publish(Course $course, CourseSection $section, Lesson $lesson)
    {
        $lesson->update([
            'is_published' => true,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('courses.sections.lessons.index', [$course, $section])
            ->with('success', 'Lesson published successfully.');
    }

    /**
     * Unpublish the specified lesson
     */
    public function unpublish(Course $course, CourseSection $section, Lesson $lesson)
    {
        $lesson->update([
            'is_published' => false,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('courses.sections.lessons.index', [$course, $section])
            ->with('success', 'Lesson unpublished successfully.');
    }

    /**
     * Reorder lessons (AJAX endpoint)
     */
    public function reorder(Request $request, Course $course, CourseSection $section)
    {
        $request->validate([
            'lessons' => 'required|array',
            'lessons.*.id' => 'required|exists:lessons,id',
            'lessons.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->lessons as $lessonData) {
            Lesson::where('id', $lessonData['id'])
                ->where('section_id', $section->id)
                ->update(['sort_order' => $lessonData['sort_order']]);
        }

        return response()->json(['message' => 'Lessons reordered successfully']);
    }
}
