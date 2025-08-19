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
        <img src="https://via.placeholder.com/400x400" alt="Illustration" class="max-w-sm">
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
                    Already have an account? <a href="#" class="text-blue-600 hover:underline">Log In</a>
                </p>

                <!-- Divider -->
                <div class="flex items-center my-4">
                    <hr class="flex-grow border-gray-300">
                    <span class="px-3 text-gray-400 text-sm">or</span>
                    <hr class="flex-grow border-gray-300">
                </div>

                <!-- Social Buttons -->
                <div class="flex justify-center space-x-4">
                    <!-- Facebook -->
                    <button type="button" class="w-10 h-10 flex items-center justify-center border rounded-full hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22 12a10 10 0 10-11.5 9.95V14.9H8v-2.9h2.5v-2.2c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.4h-1.2c-1.2 0-1.6.7-1.6 1.5v1.9h2.7l-.4 2.9h-2.3v7.05A10 10 0 0022 12z"/>
                        </svg>
                    </button>
                    <!-- Twitter -->
                    <button type="button" class="w-10 h-10 flex items-center justify-center border rounded-full hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-500" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.633 7.997c.013.176.013.353.013.529 0 5.385-4.099 11.59-11.59 11.59-2.304 0-4.44-.676-6.238-1.843.323.038.633.05.97.05 1.904 0 3.652-.65 5.046-1.754a4.085 4.085 0 01-3.817-2.834c.247.038.494.063.754.063.353 0 .707-.05 1.036-.138a4.079 4.079 0 01-3.27-4.006v-.05c.546.3 1.175.482 1.842.507a4.073 4.073 0 01-1.814-3.39c0-.75.202-1.45.558-2.054a11.57 11.57 0 008.396 4.258c-.063-.3-.1-.613-.1-.926a4.076 4.076 0 017.056-2.787 8.072 8.072 0 002.588-.988 4.06 4.06 0 01-1.79 2.243 8.17 8.17 0 002.35-.633 8.725 8.725 0 01-2.042 2.107z"/>
                        </svg>
                    </button>
                    <!-- Google -->
                    <button type="button" class="w-10 h-10 flex items-center justify-center border rounded-full hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21.35 11.1h-9.17v2.96h5.3c-.23 1.23-.93 2.28-1.98 2.98v2.46h3.2c1.87-1.72 2.95-4.27 2.95-7.4 0-.62-.06-1.23-.17-1.8z"/><path d="M12.18 22c2.7 0 4.97-.9 6.63-2.43l-3.2-2.46c-.89.6-2 1-3.43 1-2.64 0-4.87-1.78-5.67-4.16H3.19v2.6A10 10 0 0012.18 22z"/><path d="M6.51 13.95a5.95 5.95 0 010-3.9v-2.6H3.19a9.996 9.996 0 000 9.1l3.32-2.6z"/><path d="M12.18 6.04c1.47 0 2.79.51 3.84 1.52l2.87-2.87C17.13 2.6 14.86 1.7 12.18 1.7A10 10 0 003.19 7.45l3.32 2.6c.8-2.38 3.03-4.16 5.67-4.16z"/>
                        </svg>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>
