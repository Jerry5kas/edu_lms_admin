<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        /*
         * Define baseline permissions
         * Grouped logically: Users, Courses, Enrollments, Payments, Admin, System
         */
        $permissions = [
            // User management
            'user.view',
            'user.create',
            'user.update',
            'user.delete',

            // Course management
            'course.view',
            'course.create',
            'course.update',
            'course.delete',
            'lesson.manage',

            // Enrollment management
            'enrollment.view',
            'enrollment.manage',

            // Payments & orders
            'order.view',
            'order.manage',
            'payment.refund',

            // Admin utilities
            'announcement.send',
            'settings.manage',

            // System & GDPR
            'gdpr.export',
            'gdpr.erase',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['name' => $perm, 'guard_name' => 'web']
            );
        }

        /*
         * Define roles and assign permissions
         */
        $roles = [
            'Admin' => $permissions, // full access
            'Instructor' => [
                'course.view',
                'course.create',
                'course.update',
                'course.delete',
                'lesson.manage',
                'enrollment.view',
            ],
            'Student' => [
                'course.view',
                'enrollment.view',
            ],
        ];

        foreach ($roles as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($perms);
        }
    }
}
