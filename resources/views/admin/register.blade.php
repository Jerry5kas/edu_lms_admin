<!DOCTYPE html>
<html lang="en" x-data="{ showPassword: false }">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up - Edmate</title>
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
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Sign Up</h2>
        <p class="text-gray-600 text-base mb-6">Please sign up to your account and start the adventure</p>

        <!-- Form -->
        <form action="{{ route('admin.register.store') }}" method="POST" class="space-y-4">
            @csrf
            <!-- Username -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
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

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <div class="relative">
          <span class="absolute left-3 top-2.5 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8-4H8m2 8H8m12-8v8a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h12a2 2 0 012 2z" />
            </svg>
          </span>
                    <input type="email" name="email" placeholder="Type your email address" required
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
                <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters</p>
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
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-md transition text-base">Sign Up</button>
        </form>

        <!-- Login Link -->
        <p class="text-sm text-center mt-6 text-gray-600">
            Already have an account? <a href="#" class="text-blue-600 hover:underline">Log In</a>
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
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 100-18 9 9 0 000 18z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v18m9-9H3" />
                </svg>
            </a>
            <a href="#" class="p-2 rounded-full border hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-5-5H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v7a2 2 0 01-2 2h-3l-5 5z" />
                </svg>
            </a>
            <a href="#" class="p-2 rounded-full border hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 11-8 0 4 4 0 018 0zm0 0v1a3 3 0 01-3 3H9m7-4a9 9 0 11-6.218-8.56" />
                </svg>
            </a>
        </div>
    </div>
</div>
</body>
</html>
