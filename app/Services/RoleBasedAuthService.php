<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RoleBasedAuthService
{
    /**
     * Check if user can access admin panel
     */
    public function canAccessAdmin(User $user = null): bool
    {
        $user = $user ?? Auth::user();
        
        if (!$user) {
            return false;
        }

        return $user->hasAnyRole(['Super Admin', 'Admin']);
    }

    /**
     * Check if user is Super Admin
     */
    public function isSuperAdmin(User $user = null): bool
    {
        $user = $user ?? Auth::user();
        
        if (!$user) {
            return false;
        }

        return $user->hasRole('Super Admin');
    }

    /**
     * Check if user is Admin
     */
    public function isAdmin(User $user = null): bool
    {
        $user = $user ?? Auth::user();
        
        if (!$user) {
            return false;
        }

        return $user->hasRole('Admin');
    }

    /**
     * Check if user is Instructor
     */
    public function isInstructor(User $user = null): bool
    {
        $user = $user ?? Auth::user();
        
        if (!$user) {
            return false;
        }

        return $user->hasRole('Instructor');
    }

    /**
     * Check if user is Manager
     */
    public function isManager(User $user = null): bool
    {
        $user = $user ?? Auth::user();
        
        if (!$user) {
            return false;
        }

        return $user->hasRole('Manager');
    }

    /**
     * Get user's primary role
     */
    public function getPrimaryRole(User $user = null): ?string
    {
        $user = $user ?? Auth::user();
        
        if (!$user) {
            return null;
        }

        $roles = $user->getRoleNames();
        
        // Priority order: Super Admin > Admin > Instructor > Manager
        $priorityRoles = ['Super Admin', 'Admin', 'Instructor', 'Manager'];
        
        foreach ($priorityRoles as $role) {
            if ($roles->contains($role)) {
                return $role;
            }
        }

        return $roles->first();
    }

    /**
     * Get redirect route based on user's role
     */
    public function getRedirectRoute(User $user = null): string
    {
        $user = $user ?? Auth::user();
        
        if (!$user) {
            return route('login');
        }

        $primaryRole = $this->getPrimaryRole($user);

        return match ($primaryRole) {
            'Super Admin' => route('admin.dashboard'),
            'Admin' => route('dashboard.index'),
            'Instructor' => route('instructor.courses.index'),
            'Manager' => route('dashboard.index'),
            default => route('dashboard.index'),
        };
    }

    /**
     * Check if user has permission for specific action
     */
    public function hasPermission(User $user, string $permission): bool
    {
        if (!$user) {
            return false;
        }

        return $user->hasPermissionTo($permission);
    }

    /**
     * Check if user has any of the given permissions
     */
    public function hasAnyPermission(User $user, array $permissions): bool
    {
        if (!$user) {
            return false;
        }

        return $user->hasAnyPermission($permissions);
    }

    /**
     * Get all permissions for user
     */
    public function getUserPermissions(User $user = null): array
    {
        $user = $user ?? Auth::user();
        
        if (!$user) {
            return [];
        }

        return $user->getAllPermissions()->pluck('name')->toArray();
    }

    /**
     * Get all roles for user
     */
    public function getUserRoles(User $user = null): array
    {
        $user = $user ?? Auth::user();
        
        if (!$user) {
            return [];
        }

        return $user->getRoleNames()->toArray();
    }
}
