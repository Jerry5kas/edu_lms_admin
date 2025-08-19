<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return view('dashboard.register'); // resources/views/dashboard/register.blade.php
    }

    public function store(Request $request)
    {
        // handle registration logic
        return redirect()->route('dashboard.register');
    }
}
