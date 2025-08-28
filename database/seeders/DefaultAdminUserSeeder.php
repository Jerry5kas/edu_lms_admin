<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DefaultAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure Super Admin role exists (from RolesAndPermissionsSeeder)
        $superAdminRole = \Spatie\Permission\Models\Role::where('name', 'Super Admin')->first();

        if (! $superAdminRole) {
            $this->command->warn('Super Admin role not found. Run RolesAndPermissionsSeeder first.');
            return;
        }

        // Create default dashboard user
        $admin = User::firstOrCreate(
            ['email' => 'dashboard@edulearn.local'],
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

        // Assign Super Admin role
        if (! $admin->hasRole('Super Admin')) {
            $admin->assignRole('Super Admin');
        }

        $this->command->info("Default Admin user created: {$admin->email} / password");
    }
}
