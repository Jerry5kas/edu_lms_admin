<!DOCTYPE html>
<html lang="en" x-data="{ showPassword: false }">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In - Edmate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.5/cdn.min.js" defer></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50 font-sans">
<div class="flex w-full max-w-6xl bg-white shadow-lg rounded-lg overflow-hidden">

    <!-- Left Side Image -->
    <div class="hidden md:flex w-1/2 bg-gray-100 items-center justify-center">
        <img src="your-image.svg" alt="Illustration" class="w-3/4 h-auto">
    </div>

    <!-- Right Side Form -->
    <div class="w-full md:w-1/2 p-6 sm:p-8 md:p-12">
        <!-- Logo -->
        <div class="flex items-center space-x-2 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01-12.32 0L12 14z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 009-9H3a9 9 0 009 9z" />
            </svg>
            <span class="font-bold text-xl text-gray-800">Edmate</span>
        </div>

        <!-- Heading -->
        <h2 class="text-3xl font-bold text-gray-900 mb-2 flex items-center">
            Welcome to Back! <span class="ml-1">👋</span>
        </h2>
        <p class="text-gray-600 text-base mb-6">Please sign in to your account and start the adventure</p>

        <!-- Form -->
        <form action="#" method="POST" class="space-y-4">
            <!-- Email or Username -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email or Username</label>
                <div class="relative">
          <span class="absolute left-3 top-2.5 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
          </span>
                    <input type="text" name="username" placeholder="Type your username" required
                           class="w-full pl-10 pr-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400 text-gray-800 text-sm sm:text-base" />
                </div>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                <div class="relative">
          <span class="absolute left-3 top-2.5 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c.379 0 .725.214.895.553a1 1 0 01-1.79.894A1 1 0 0112 11zm0-6a4 4 0 00-4 4v1H8a2 2 0 00-2 2v5a2 2 0 002 2h8a2 2 0 002-2v-5a2 2 0 00-2-2h0v-1a4 4 0 00-4-4z" />
            </svg>
          </span>
                    <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="********" required
                           class="w-full pl-10 pr-10 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400 text-gray-800 text-sm sm:text-base" />
                    <button type="button" @click="showPassword = !showPassword"
                            class="absolute right-3 top-2.5 text-gray-400 focus:outline-none">
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.051 10.051 0 013.264-4.419M9.88 9.88a3 3 0 104.24 4.24M6.1 6.1l11.8 11.8" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Remember + Forgot -->
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center space-x-2 text-gray-600">
                    <input type="checkbox" class="rounded border-gray-300">
                    <span>Remember Me</span>
                </label>
                <a href="#" class="text-blue-600 hover:underline">Forgot Password?</a>
            </div>

            <!-- Button -->
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-md transition text-base">Sign In</button>
        </form>

        <!-- Create Account -->
        <p class="text-sm text-center mt-6 text-gray-600">
            New on our platform? <a href="#" class="text-blue-600 hover:underline">Create an account</a>
        </p>

        <!-- Divider -->
        <div class="flex items-center my-6">
            <hr class="flex-grow border-gray-300">
            <span class="px-2 text-gray-400 text-sm">or</span>
            <hr class="flex-grow border-gray-300">
        </div>

        <!-- Socials -->
        <div class="flex justify-center space-x-4">
            <a href="#" class="p-2 rounded-full border hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M22.675 0h-21.35C.597 0 0 .597 0 1.325v21.351C0 23.403.597 24 1.325 24h11.494v-9.294H9.692v-3.622h3.127V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.505 0-1.797.715-1.797 1.763v2.312h3.59l-.467 3.622h-3.123V24h6.116C23.403 24 24 23.403 24 22.676V1.325C24 .597 23.403 0 22.675 0z"/>
                </svg>
            </a>
            <a href="#" class="p-2 rounded-full border hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-sky-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.954 4.569c-.885.392-1.83.656-2.825.775
          1.014-.611 1.794-1.574 2.163-2.724-.951.564-2.005.974-3.127
          1.195-.897-.959-2.178-1.555-3.594-1.555-2.717
          0-4.924 2.206-4.924 4.924 0 .39.045.765.127
          1.124-4.09-.205-7.719-2.165-10.148-5.144-.424.729-.666
          1.577-.666 2.475 0 1.708.87 3.216 2.188
          4.099-.807-.026-1.566-.247-2.228-.616v.061c0
          2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.317
          0-.626-.031-.928-.088.627 1.956 2.444 3.379
          4.6 3.419-1.68 1.318-3.809 2.105-6.102
          2.105-.397 0-.788-.023-1.175-.069 2.179
          1.397 4.768 2.211 7.557 2.211 9.054
          0 14.001-7.496 14.001-13.986 0-.21
          0-.423-.015-.634.961-.689 1.8-1.56 2.46-2.548l-.047-.02z"/>
                </svg>
            </a>
            <a href="#" class="p-2 rounded-full border hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M21.35 11.1h-9.15v2.82h6.46c-.29 1.54-1.64 4.52-6.46
          4.52-3.89 0-7.05-3.19-7.05-7.11s3.16-7.11 7.05-7.11c2.21
          0 3.69.94 4.54 1.74l2.46-2.37c-1.45-1.36-3.34-2.18-7-2.18-5.79
          0-10.5 4.71-10.5 10.5s4.71 10.5 10.5
          10.5c6.06 0 10.09-4.26 10.09-10.27 0-.69-.08-1.21-.19-1.72z"/>
                </svg>
            </a>
        </div>
    </div>
</div>
</body>
</html>
