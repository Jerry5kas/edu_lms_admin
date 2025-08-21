<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class StudentCourseController extends Controller
{
    public function index()
    {
        // Later you can load data here (e.g., $courses = Course::...;)
        return view('dashboard.courses.student.index'); // matches resources/views/dashboard/student/index.blade.php
    }
}
