<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DefaultAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure admin role exists (from RolesAndPermissionsSeeder)
        $adminRole = \Spatie\Permission\Models\Role::where('name', 'Admin')->first();

        if (! $adminRole) {
            $this->command->warn('Admin role not found. Run RolesAndPermissionsSeeder first.');
            return;
        }

        // Create default admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@edulearn.local'],
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'name' => 'Super Admin',
                'password' => Hash::make('password'), // 🔐 Change this in production!
                'locale' => 'de_DE',
                'timezone' => 'Europe/Berlin',
                'country_code' => 'DE',
                'marketing_opt_in' => false,
            ]
        );

        // Assign Admin role
        if (! $admin->hasRole('Admin')) {
            $admin->assignRole('Admin');
        }

        $this->command->info("Default Admin user created: {$admin->email} / password");
    }
}
