<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user has admin role (Super Admin or Admin)
        if (!$user->hasAnyRole(['Super Admin', 'Admin'])) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Access denied! Only admin users allowed']);
        }

        return $next($request);
    }
}
