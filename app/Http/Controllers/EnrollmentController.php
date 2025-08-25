<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    // Show all enrolled courses for the logged-in user
    public function index()
    {
        $enrollments = Enrollment::with('course')
            ->where('user_id', auth()->id())
            ->get();

        return view('enrollments.index', compact('enrollments'));
    }

    // Enroll the logged-in user into a course
    public function store(Course $course)
    {
        $user = auth()->user();

        // Prevent duplicate enrollments
        $existing = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existing) {
            return redirect()->route('my.courses')->with('info', 'You are already enrolled in this course.');
        }

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'source' => 'admin_grant', // later this will change to 'purchase' via payment
            'status' => 'active',
            'activated_at' => now(),
        ]);

        return redirect()->route('my.courses')->with('success', 'Successfully enrolled in ' . $course->title);
    }
}

