<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return view('admin.register'); // resources/views/admin/register.blade.php
    }

    public function store(Request $request)
    {
        // handle registration logic
        return redirect()->route('admin.register');
    }
}
