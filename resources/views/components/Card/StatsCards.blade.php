<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stats Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div x-data class="bg-white rounded-2xl shadow-md p-5 w-full max-w-sm sm:max-w-md relative overflow-hidden">

    <!-- Top Section -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="bg-blue-500 text-white rounded-full p-3">
                <!-- Calendar Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2
                     2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="font-medium text-gray-700 text-sm sm:text-base">Time Spend</span>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="mt-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">48:32:18</h2>
        <p class="text-red-500 text-sm flex items-center space-x-1 mt-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
            <span>2:25:08</span>
        </p>
    </div>

    <!-- Chart Background -->
    <div class="absolute bottom-0 right-0 w-32 sm:w-40 opacity-80">
        <svg viewBox="0 0 200 100" class="w-full h-full text-blue-200">
            <path fill="currentColor" fill-opacity="0.4"
                  d="M0,80 Q40,20 80,60 T160,50 T200,30 V100 H0 Z"/>
        </svg>
    </div>
</div>

</body>
</html>
