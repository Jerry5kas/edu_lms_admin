<!DOCTYPE html>
<html lang="en" x-data="{ showPassword: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 px-4">

<div class="flex w-full max-w-5xl bg-white rounded-2xl shadow-lg overflow-hidden">

    <!-- Left Illustration (hidden on small screens) -->
    <div class="hidden lg:flex w-1/2 bg-gray-50 items-center justify-center p-8">
        <img src="{{ asset('images/sinup.png') }}" alt="Illustration" class="max-w-sm">
    </div>

    <!-- Right Side -->
    <div class="flex flex-col justify-center w-full lg:w-1/2 bg-white p-8">
        <div class="w-full max-w-md mx-auto">

            <!-- Logo + Brand -->
            <div class="flex items-center justify-center mb-6 space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m0 0H9m3 0h3" />
                </svg>
                <h1 class="text-2xl font-bold text-gray-800">Edmate</h1>
            </div>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-gray-900 mb-1 text-center lg:text-left">Sign Up</h2>
            <p class="text-gray-500 text-sm mb-6 text-center lg:text-left">
                Please sign up to your account and start the adventure
            </p>

            <!-- Form -->
            <form class="space-y-5">

                <!-- Username -->
                <div>
                    <div class="flex items-center border rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1117.805 5.12 9 9 0 015.12 17.805z" />
                        </svg>
                        <input id="username" type="text" placeholder="Type your username" class="w-full border-none focus:ring-0 text-gray-700 text-sm" />
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <div class="flex items-center border rounded-lg px-3 py-2 focus-within:ring-2 ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <input id="email" type="email" placeholder="Type your email address" class="w-full  text-gray-700 " />
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center border rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c.528 0 1.04.21 1.414.586A2 2 0 0112 15a2 2 0 010-4z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <input id="password" :type="showPassword ? 'text' : 'password'" placeholder="********" class="w-full border-none focus:ring-0 text-gray-700 text-sm" />
                        <button type="button" @click="showPassword = !showPassword" class="ml-2 text-gray-400 focus:outline-none">
                            <!-- Eye Off -->
                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <!-- Eye -->
                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 013.023-4.419m3.91-2.523A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-3.023 4.419M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Must be at least 8 characters</p>
                </div>

                <!-- Remember Me + Forgot -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-gray-600">Remember Me</span>
                    </label>
                    <a href="#" class="text-blue-600 hover:underline">Forgot Password?</a>
                </div>

                <!-- Submit -->
                <!-- Button -->
                <a href="{{route('dashboard')}}">
                    <button
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 mt-2 rounded-md transition text-base">
                        Sign Up
                    </button>
                </a>
                <!-- Login redirect -->
                <p class="text-center text-sm text-gray-600">
                    Already have an account? <a href="/login" class="text-blue-600 hover:underline">Log In</a>
                </p>

            </form>
        </div>
    </div>
</div>

</body>
</html>
