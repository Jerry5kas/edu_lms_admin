<div class=" flex items-center justify-between px-4 py-3 bg-white border-b" x-data="{ sidebarOpen: false }">
    <!-- Left -->
    <button class="lg:hidden p-2 rounded-md bg-gray-100" @click="sidebarOpen = true">
        <!-- Heroicon Menu -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Search -->
    <div class="flex-1 flex justify-center px-2">
        <input type="text" placeholder="Search..." class="w-full sm:w-3/4 md:w-1/2 px-4 py-2 rounded-lg border focus:outline-blue-400"/>
    </div>

    <!-- Right -->
    <div class="flex items-center gap-4">
        <!-- Notification Button -->
        <div class="relative flex justify-end" x-data="{ open: false }">
            <button
                @click="open = !open"
                class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 focus:outline-none"
            >
                <!-- Heroicon Bell -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button>


            <!-- Dropdown -->
            <div
                x-show="open"
                @click.outside="open = false"
                x-transition
                class="absolute right-0 mt-2 w-72 bg-white shadow-lg rounded-xl ring-1 ring-gray-200 z-50"
            >
                <!-- Header -->
                <div class="px-4 py-3 border-b">
                    <h3 class="text-sm font-semibold text-gray-800">Notifications</h3>
                </div>

                <!-- Notification Items -->
                <ul class="max-h-60 overflow-y-auto divide-y">
                    <li class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                        <svg class="h-5 w-5 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        You have a new message
                    </li>

                    <li class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                        <svg class="h-5 w-5 text-yellow-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>
                        </svg>
                        Reminder: Meeting at 5 PM
                    </li>
                </ul>
            </div>
        </div>

        <!-- Profile Dropdown -->
        <div class="relative flex justify-end" x-data="{ open: false }">
            <!-- Profile Button -->
            <button
                @click="open = !open"
                class="flex items-center space-x-2 rounded-full focus:outline-none"
            >
                <img src="{{ Auth::check() && Auth::user()->profile
                        ? asset('storage/profile_images/' . Auth::user()->profile)
                        : 'https://via.placeholder.com/150/3B82F6/FFFFFF?text=' . substr(Auth::user()->name ?? 'U', 0, 1) }}"
                     alt="Profile"
                     class="w-10 h-10 rounded-full border-2 border-blue-500" />
{{--                <img class="w-10 h-10 rounded-full border-2 border-blue-500" src="https://via.placeholder.com/150" alt="User">--}}
            </button>

            <!-- Dropdown -->
            <div
                x-show="open"
                @click.outside="open = false"
                x-transition
                class="absolute right-0 mt-2 w-60 bg-white shadow-lg rounded-xl ring-1 ring-gray-200 z-50"
            >
                <!-- User Info -->
                <div class="flex items-center space-x-3 p-4 border-b">
                    <img src="{{ Auth::check() && Auth::user()->profile
                        ? asset('storage/profile_images/' . Auth::user()->profile)
                        : 'https://via.placeholder.com/150/3B82F6/FFFFFF?text=' . substr(Auth::user()->name ?? 'U', 0, 1) }}"
                         alt="Profile"
                         class="w-10 h-10 rounded-full" />
{{--                    <img class="w-10 h-10 rounded-full" src="https://via.placeholder.com/150" alt="User">--}}
                    <div>
                        <h2 class="text-sm font-semibold text-gray-800">
                                {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                            </h2>
                        <p class="text-xs text-gray-500">

                           {{ Auth::user()->email ?? '' }}


                        </p>
                    </div>
                </div>

                <!-- Menu Items -->
                <ul class="p-2">
                    <li>
                        <a href="{{ route('auth.profile.edit') }}" class="flex items-center px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-100">
                            <!-- User Icon -->
                            <img src="" alt="">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5a8.25 8.25 0 1115 0" />
                            </svg>
                           Profile
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-2 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-100">
                            <!-- User Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.983 13.883a1.905 1.905 0 100-3.81 1.905 1.905 0 000 3.81z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.423 12.667c.036-.22.057-.445.057-.677s-.021-.457-.057-.677l1.505-1.174a.381.381 0 00.092-.493l-1.428-2.474a.381.381 0 00-.478-.162l-1.774.713a6.574 6.574 0 00-1.173-.677l-.27-1.889a.381.381 0 00-.378-.326h-2.856a.381.381 0 00-.378.326l-.27 1.889a6.574 6.574 0 00-1.173.677l-1.774-.713a.381.381 0 00-.478.162l-1.428 2.474a.381.381 0 00.092.493l1.505 1.174c-.036.22-.057.445-.057.677s.021.457.057.677l-1.505 1.174a.381.381 0 00-.092.493l1.428 2.474c.104.18.32.249.478.162l1.774-.713c.367.278.761.51 1.173.677l.27 1.889c.03.184.194.326.378.326h2.856c.184 0 .348-.142.378-.326l.27-1.889c.412-.167.806-.399 1.173-.677l1.774.713c.158.087.374.018.478-.162l1.428-2.474a.381.381 0 00-.092-.493l-1.505-1.174z" />
                            </svg>
                             Account Settings
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-100">
                            <!-- Chart Bar Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18M17 13V6M12 18V10M7 21V14" />
                            </svg>
                            Daily Activity
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-100">
                            <!-- Inbox Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-4l-2 3H10l-2-3H4" />
                            </svg>
                            Inbox
                        </a>
                    </li>
                </ul>

                <!-- Logout -->
                <div class="border-t">
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center px-3 py-3 rounded-b-xl text-sm font-medium text-red-600 hover:bg-red-50 w-full text-left">
                        <!-- Logout Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1m0-10V5a2 2 0 114 0v1" />
                        </svg>
                        Logout
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
