<?php

/**
 * Role-Based Authentication Setup Script
 * 
 * This script helps set up the role-based authentication system.
 * Run this script to verify and set up the authentication system.
 */

echo "🔐 Role-Based Authentication Setup Script\n";
echo "==========================================\n\n";

// Check if Laravel is available
if (!file_exists('artisan')) {
    echo "❌ Error: Laravel artisan file not found. Please run this script from the Laravel project root.\n";
    exit(1);
}

// Function to run artisan commands
function runArtisan($command) {
    echo "Running: php artisan $command\n";
    $output = shell_exec("php artisan $command 2>&1");
    echo $output . "\n";
    return $output;
}

// Function to check if command was successful
function checkSuccess($output) {
    return strpos($output, 'Error') === false && strpos($output, 'Exception') === false;
}

echo "1. 🔄 Clearing caches...\n";
runArtisan('cache:clear');
runArtisan('config:clear');
runArtisan('route:clear');
runArtisan('view:clear');

echo "2. 🗄️ Running migrations...\n";
$migrationOutput = runArtisan('migrate');
if (!checkSuccess($migrationOutput)) {
    echo "❌ Migration failed. Please check your database configuration.\n";
    exit(1);
}

echo "3. 🌱 Seeding roles and permissions...\n";
$seederOutput = runArtisan('db:seed --class=RolesAndPermissionsSeeder');
if (!checkSuccess($seederOutput)) {
    echo "❌ Role seeder failed.\n";
    exit(1);
}

echo "4. 👤 Creating default users...\n";
$adminOutput = runArtisan('db:seed --class=DefaultAdminUserSeeder');
$usersOutput = runArtisan('db:seed --class=DefaultUsersSeeder');

if (!checkSuccess($adminOutput) || !checkSuccess($usersOutput)) {
    echo "❌ User seeder failed.\n";
    exit(1);
}

echo "5. 🔧 Clearing permission cache...\n";
runArtisan('permission:cache-reset');

echo "6. ✅ Setup completed successfully!\n\n";

echo "📋 Default Users Created:\n";
echo "========================\n";
echo "Super Admin: dashboard@edulearn.local / password\n";
echo "Instructor:  instructor@edulearn.local / password\n";
echo "Student:     all courses@edulearn.local / password\n\n";

echo "🔗 Quick Links:\n";
echo "==============\n";
echo "Login Page: http://127.0.0.1:8000\n";
echo "Admin Dashboard: http://127.0.0.1:8000/admin/dashboard\n";
echo "Regular Dashboard: http://127.0.0.1:8000/dashboard\n\n";

echo "📚 Documentation:\n";
echo "=================\n";
echo "See ROLE_BASED_AUTHENTICATION_GUIDE.md for detailed documentation.\n\n";

echo "🚀 Next Steps:\n";
echo "==============\n";
echo "1. Start the development server: php artisan serve\n";
echo "2. Test login with the default users above\n";
echo "3. Verify role-based access works correctly\n";
echo "4. Customize roles and permissions as needed\n\n";

echo "🎉 Role-based authentication system is ready!\n";
