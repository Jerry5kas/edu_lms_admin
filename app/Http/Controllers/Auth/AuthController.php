<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
// Handle login
     public function showlogin(){
         return view('auth.login');
     }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt login
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();

//        // Allow only admin role (you can also allow instructor if needed)
//        if (!$user->hasRole('admin')) {
//            Auth::logout();
//            return response()->json(['message' => 'Access denied! Only admin allowed'], 403);
//        }

        // Generate Sanctum token
        $token = $user->createToken('api-token')->plainTextToken;

        return view('dashboard.index', compact('user', 'token'));
    }
    public function dashboard(){
        return view('dashboard.index');
    }
// Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->user()->currentAccessToken()->delete();
        return view('auth.login');
    }
}
