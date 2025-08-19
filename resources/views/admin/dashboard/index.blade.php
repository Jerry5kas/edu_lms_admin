<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Edmate</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01-12.32 0L12 14z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 009-9H3a9 9 0 009 9z" />
                        </svg>
                        <span class="font-bold text-2xl">Edmate</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Welcome, Admin!</span>
                        <a href="{{ route('admin.register') }}" class="text-blue-600 hover:text-blue-800">Logout</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="border-4 border-dashed border-gray-200 rounded-lg h-96 flex items-center justify-center">
                    <div class="text-center">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">Welcome to Admin Dashboard</h1>
                        <p class="text-gray-600 mb-6">Your registration was successful!</p>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            Registration completed successfully. You can now manage your LMS platform.
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
