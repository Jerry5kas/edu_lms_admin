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
         * Define comprehensive permissions
         * Grouped logically: Users, Courses, Enrollments, Payments, Admin, System, Roles & Permissions
         */
        $permissions = [
            // User management
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // Course management
            'courses.view',
            'courses.create',
            'courses.edit',
            'courses.delete',
            'courses.publish',
            'courses.unpublish',

            // Course sections
            'sections.view',
            'sections.create',
            'sections.edit',
            'sections.delete',

            // Lessons
            'lessons.view',
            'lessons.create',
            'lessons.edit',
            'lessons.delete',
            'lessons.publish',
            'lessons.unpublish',

            // Enrollment management
            'enrollments.view',
            'enrollments.manage',

            // Payments & orders
            'orders.view',
            'orders.manage',
            'orders.cancel',
            'payments.view',
            'payments.manage',
            'refunds.view',
            'refunds.process',
            'invoices.view',
            'invoices.download',

            // Media management
            'media.view',
            'media.upload',
            'media.delete',

            // Quizzes
            'quizzes.view',
            'quizzes.create',
            'quizzes.edit',
            'quizzes.delete',

            // Categories & Tags
            'categories.view',
            'categories.create',
            'categories.edit',
            'categories.delete',
            'tags.view',
            'tags.create',
            'tags.edit',
            'tags.delete',

            // Roles & Permissions management
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
            'roles.sync-permissions',
            'permissions.view',
            'permissions.create',
            'permissions.edit',
            'permissions.delete',

            // Admin utilities
            'announcements.send',
            'settings.manage',
            'dashboard.access',

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
            'Super Admin' => $permissions, // full access to everything
            'Admin' => array_filter($permissions, function($perm) {
                // Admin gets everything except Super Admin specific permissions
                return !in_array($perm, ['roles.delete', 'permissions.delete']);
            }),
            'Instructor' => [
                'courses.view',
                'courses.create',
                'courses.edit',
                'courses.publish',
                'courses.unpublish',
                'sections.view',
                'sections.create',
                'sections.edit',
                'sections.delete',
                'lessons.view',
                'lessons.create',
                'lessons.edit',
                'lessons.delete',
                'lessons.publish',
                'lessons.unpublish',
                'media.view',
                'media.upload',
                'quizzes.view',
                'quizzes.create',
                'quizzes.edit',
                'quizzes.delete',
                'categories.view',
                'tags.view',
                'enrollments.view',
                'dashboard.access',
            ],
            'Manager' => [
                'users.view',
                'courses.view',
                'courses.edit',
                'courses.publish',
                'courses.unpublish',
                'sections.view',
                'sections.edit',
                'lessons.view',
                'lessons.edit',
                'lessons.publish',
                'lessons.unpublish',
                'enrollments.view',
                'enrollments.manage',
                'orders.view',
                'orders.manage',
                'payments.view',
                'refunds.view',
                'refunds.process',
                'invoices.view',
                'invoices.download',
                'media.view',
                'quizzes.view',
                'quizzes.edit',
                'categories.view',
                'categories.edit',
                'tags.view',
                'tags.edit',
                'dashboard.access',
            ],

        ];

        foreach ($roles as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($perms);
        }
    }
}
