# Role-Based Authentication System Documentation

## Overview

This document provides a comprehensive guide to the role-based authentication system implemented in the Edmate LMS application. The system uses Spatie Laravel Permission package for managing roles and permissions.

## 🔧 System Architecture

### Core Components

1. **User Model** (`app/Models/User.php`)
   - Uses `HasRoles` trait from Spatie Permission
   - Supports multiple roles per user
   - Includes soft deletes and audit logging

2. **Authentication Controller** (`app/Http/Controllers/Auth/WebAuthController.php`)
   - Handles login/logout logic
   - Role-based access validation
   - Dynamic redirects based on user role

3. **Middleware Stack**
   - `AdminMiddleware`: Protects admin routes
   - `RoleMiddleware`: Custom role checking
   - `PermissionMiddleware`: Custom permission checking

4. **Service Layer** (`app/Services/RoleBasedAuthService.php`)
   - Centralized role and permission logic
   - Helper methods for common checks
   - Route determination based on roles

## 🏗️ Role Hierarchy

### Defined Roles (Priority Order)

1. **Super Admin** (Highest Priority)
   - Full system access
   - Can manage all roles and permissions
   - Access to all admin features

2. **Admin**
   - Administrative access
   - Can manage users, courses, orders
   - Limited role management

3. **Instructor**
   - Course creation and management
   - Student progress tracking
   - Content management

4. **Manager** (Lowest Priority)
   - Order and payment management
   - User management
   - Administrative tasks

## 🔐 Permission System

### Permission Categories

#### User Management
- `users.view` - View user profiles
- `users.create` - Create new users
- `users.edit` - Edit user information
- `users.delete` - Delete users

#### Course Management
- `courses.view` - View courses
- `courses.create` - Create new courses
- `courses.edit` - Edit course content
- `courses.delete` - Delete courses
- `courses.publish` - Publish courses
- `courses.unpublish` - Unpublish courses

#### Content Management
- `sections.view/create/edit/delete` - Course sections
- `lessons.view/create/edit/delete/publish/unpublish` - Course lessons
- `media.view/upload/delete` - Media files
- `quizzes.view/create/edit/delete` - Quizzes

#### Administrative
- `roles.view/create/edit/delete` - Role management
- `permissions.view/create/edit/delete` - Permission management
- `orders.view/manage/cancel` - Order management
- `payments.view/manage` - Payment processing
- `refunds.view/process` - Refund handling

## 🚀 Implementation Guide

### 1. Database Setup

```bash
# Run migrations
php artisan migrate

# Seed roles and permissions
php artisan db:seed --class=RolesAndPermissionsSeeder

# Create default users
php artisan db:seed --class=DefaultAdminUserSeeder
php artisan db:seed --class=DefaultUsersSeeder
```

### 2. Default Users

After seeding, the following users are available:

| Email | Password | Role | Access Level |
|-------|----------|------|--------------|
| `dashboard@edulearn.local` | `password` | Super Admin | Full Access |
| `instructor@edulearn.local` | `password` | Instructor | Course Management |
| `manager@edulearn.local` | `password` | Manager | Administrative Tasks |

### 3. Route Protection

#### Admin Routes
```php
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin-only routes
});
```

#### Role-Specific Routes
```php
Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    // Super Admin only routes
});

Route::middleware(['auth', 'role:Instructor'])->group(function () {
    // Instructor only routes
});
```

#### Permission-Based Routes
```php
Route::middleware(['auth', 'permission:courses.create'])->group(function () {
    // Routes requiring specific permission
});
```

### 4. Controller Usage

#### Basic Role Checks
```php
use App\Services\RoleBasedAuthService;

class CourseController extends Controller
{
    protected $authService;

    public function __construct(RoleBasedAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        if (!$this->authService->isInstructor()) {
            abort(403, 'Instructor access required');
        }

        // Controller logic
    }
}
```

#### Permission Checks
```php
public function store(Request $request)
{
    if (!$this->authService->hasPermission(Auth::user(), 'courses.create')) {
        abort(403, 'Permission denied');
    }

    // Create course logic
}
```

### 5. Blade Template Usage

#### Role Checks in Views
```php
@if(auth()->user()->hasRole('Super Admin'))
    <div class="admin-panel">
        <!-- Super Admin content -->
    </div>
@endif

@if(auth()->user()->hasRole('Instructor'))
    <div class="instructor-panel">
        <!-- Instructor content -->
    </div>
@endif

@if(auth()->user()->hasRole('Manager'))
    <div class="manager-panel">
        <!-- Manager content -->
    </div>
@endif
```

#### Permission Checks in Views
```php
@can('courses.create')
    <a href="{{ route('courses.create') }}" class="btn btn-primary">
        Create Course
    </a>
@endcan

@can('users.delete')
    <button class="btn btn-danger">Delete User</button>
@endcan
```

## 🔧 Customization

### Adding New Roles

1. **Update Seeder**
```php
// In RolesAndPermissionsSeeder.php
$roles = [
    'New Role' => [
        'permission1',
        'permission2',
        // ... permissions
    ],
];
```

2. **Update Service**
```php
// In RoleBasedAuthService.php
public function isNewRole(User $user = null): bool
{
    $user = $user ?? Auth::user();
    return $user && $user->hasRole('New Role');
}
```

### Adding New Permissions

1. **Define Permission**
```php
// In RolesAndPermissionsSeeder.php
$permissions = [
    // ... existing permissions
    'new.feature.access',
    'new.feature.manage',
];
```

2. **Assign to Roles**
```php
$roles = [
    'Super Admin' => $permissions, // Gets all permissions
    'Admin' => array_filter($permissions, function($perm) {
        return !in_array($perm, ['roles.delete']);
    }),
    // ... other roles
];
```

## 🛡️ Security Best Practices

### 1. Always Validate Permissions
```php
// ✅ Good
if (!$this->authService->hasPermission($user, 'users.delete')) {
    abort(403);
}

// ❌ Bad - Don't rely only on UI hiding
```

### 2. Use Middleware for Route Protection
```php
// ✅ Good
Route::middleware(['auth', 'permission:users.delete'])->delete('/users/{user}', [UserController::class, 'destroy']);

// ❌ Bad - Don't rely only on controller checks
```

### 3. Validate User Input
```php
// Always validate role assignments
$request->validate([
    'role' => 'required|exists:roles,name'
]);
```

### 4. Audit Logging
```php
// Log important actions
Log::info('User role changed', [
    'user_id' => $user->id,
    'old_role' => $oldRole,
    'new_role' => $newRole,
    'changed_by' => Auth::id()
]);
```

## 🔍 Troubleshooting

### Common Issues

1. **"Access denied! Only admin users allowed"**
   - Check if user has 'Super Admin' or 'Admin' role
   - Verify roles were seeded correctly
   - Check database for role assignments

2. **Permission not working**
   - Clear permission cache: `php artisan permission:cache-reset`
   - Verify permission exists in database
   - Check role-permission assignments

3. **Middleware not working**
   - Verify middleware is registered in `app/Http/Kernel.php`
   - Check route middleware application
   - Clear route cache: `php artisan route:clear`

### Debug Commands

```bash
# Check user roles
php artisan tinker
>>> Auth::user()->getRoleNames()

# Check user permissions
>>> Auth::user()->getAllPermissions()->pluck('name')

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan permission:cache-reset
```

## 📋 API Reference

### RoleBasedAuthService Methods

| Method | Description | Returns |
|--------|-------------|---------|
| `canAccessAdmin($user)` | Check admin panel access | bool |
| `isSuperAdmin($user)` | Check if Super Admin | bool |
| `isAdmin($user)` | Check if Admin | bool |
| `isInstructor($user)` | Check if Instructor | bool |
| `isManager($user)` | Check if Manager | bool |
| `getPrimaryRole($user)` | Get highest priority role | string|null |
| `getRedirectRoute($user)` | Get role-based redirect | string |
| `hasPermission($user, $permission)` | Check specific permission | bool |
| `hasAnyPermission($user, $permissions)` | Check any permission | bool |
| `getUserPermissions($user)` | Get all user permissions | array |
| `getUserRoles($user)` | Get all user roles | array |

### User Model Methods (Spatie)

| Method | Description |
|--------|-------------|
| `hasRole($role)` | Check if user has specific role |
| `hasAnyRole($roles)` | Check if user has any of the roles |
| `hasAllRoles($roles)` | Check if user has all roles |
| `hasPermissionTo($permission)` | Check specific permission |
| `hasAnyPermission($permissions)` | Check any permission |
| `getRoleNames()` | Get all role names |
| `getAllPermissions()` | Get all permissions |
| `assignRole($role)` | Assign role to user |
| `removeRole($role)` | Remove role from user |
| `syncRoles($roles)` | Sync user roles |

## 🚀 Deployment Checklist

- [ ] Run all migrations
- [ ] Seed roles and permissions
- [ ] Create default admin user
- [ ] Test role-based access
- [ ] Verify middleware protection
- [ ] Check permission assignments
- [ ] Test API endpoints
- [ ] Validate frontend role checks
- [ ] Clear all caches
- [ ] Update environment variables

## 📞 Support

For issues or questions about the role-based authentication system:

1. Check this documentation
2. Review the troubleshooting section
3. Check Laravel logs: `storage/logs/laravel.log`
4. Verify database role/permission tables
5. Test with default users provided

---

**Last Updated**: December 2024
**Version**: 1.0.0
