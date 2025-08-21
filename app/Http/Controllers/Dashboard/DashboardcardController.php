<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;


class DashboardcardController extends Controller
{
    public function index()
    {
        // Later you can load data here (e.g., $courses = Course::...;)
        return view('dashboard.maindashboard.index'); // matches resources/views/dashboard/student/index.blade.php
    }
}

