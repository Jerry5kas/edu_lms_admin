<?php


namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
     public function register(Request $request){
         $request->validate([
             'name' => 'required',
             'email' => 'required|email|unique:users',
             'password' => 'required|min:6'
         ]);
         $user = User::create([
             'name' => $request->name,
             'email' => $request->email,
             'password' => Hash::make($request->password)
         ]);
         $token = $user->createToken('api-token')->plainTextToken;
         return response()->json([
             'message' => 'User registered successfully',
             'user' => $user,
             'token' => $token
         ], 200);
     }
// Handle login
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

        // Allow only admin role (you can also allow instructor if needed)
//        if (!$user->hasRole('admin')) {
//            Auth::logout();
//            return response()->json(['message' => 'Access denied! Only admin allowed'], 403);
//        }

        // Generate Sanctum token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user'    => $user,
            'token'   => $token
        ], 200);
    }
// Handle logout
    public function logout(Request $request)
    {
//        Auth::logout();
//        $request->session()->invalidate();
//        $request->session()->regenerateToken();
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
