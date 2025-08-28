<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission, string ...$permissions): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $requiredPermissions = array_merge([$permission], $permissions);

        // Check if user has any of the required permissions
        if (!$user->hasAnyPermission($requiredPermissions)) {
            abort(403, 'Access denied! Insufficient permissions.');
        }

        return $next($request);
    }
}
