<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DefaultUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure roles exist (should be created by RolesAndPermissionsSeeder)
        $roles = Role::pluck('name')->toArray();
        $required = ['Admin','Instructor','Student'];

        foreach ($required as $role) {
            if (! in_array($role, $roles)) {
                $this->command->warn("Role '{$role}' not found. Run RolesAndPermissionsSeeder first.");
                return;
            }
        }

        // Default Admin
        $admin = User::firstOrCreate(
            ['email' => 'dashboard@edulearn.local'],
            [
                'uuid' => Str::uuid(),
                'name' => 'Super Admin',
                'password' => Hash::make('password'), // ⚠️ change in production
                'locale' => 'de_DE',
                'timezone' => 'Europe/Berlin',
                'country_code' => 'DE',
            ]
        );
        $admin->assignRole('Admin');

        // Default Instructor
        $instructor = User::firstOrCreate(
            ['email' => 'instructor@edulearn.local'],
            [
                'uuid' => Str::uuid(),
                'name' => 'Demo Instructor',
                'password' => Hash::make('password'), // ⚠️ change in production
                'locale' => 'de_DE',
                'timezone' => 'Europe/Berlin',
                'country_code' => 'DE',
            ]
        );
        $instructor->assignRole('Instructor');

        // Default Student
        $student = User::firstOrCreate(
            ['email' => 'all courses@edulearn.local'],
            [
                'uuid' => Str::uuid(),
                'name' => 'Demo Student',
                'password' => Hash::make('password'), // ⚠️ change in production
                'locale' => 'de_DE',
                'timezone' => 'Europe/Berlin',
                'country_code' => 'DE',
            ]
        );
        $student->assignRole('Student');

        $this->command->info("✅ Default users created:");
        $this->command->info("   Admin: dashboard@edulearn.local / password");
        $this->command->info("   Instructor: instructor@edulearn.local / password");
        $this->command->info("   Student: all courses@edulearn.local / password");
    }
}
