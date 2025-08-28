<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\RoleBasedAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebAuthController extends Controller
{
    protected $authService;

    public function __construct(RoleBasedAuthService $authService)
    {
        $this->authService = $authService;
    }

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

        $user = Auth::user();
        
        // Check if user has any admin role (Super Admin or Admin)
        if (!$this->authService->canAccessAdmin($user)) {
            Auth::logout();
            return back()->withErrors(['email' => 'Access denied! Only admin users allowed'])->withInput();
        }

        // Redirect based on role
        return redirect($this->authService->getRedirectRoute($user));
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
