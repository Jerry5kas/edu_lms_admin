<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebAuthController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login (session)
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        // Prevent session fixation
        $request->session()->regenerate();

        // Optional: role check with Spatie
        if (!Auth::user()->hasRole('Admin')) {
            Auth::logout();
            return back()->withErrors(['email' => 'Access denied! Only admin allowed'])->withInput();
        }

        return redirect()->route('dashboard.index');
    }

    // Dashboard
    public function dashboard()
    {
        $user = Auth::user();
        return view('dashboard.index', compact('user'));
    }

    // Logout (session)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
