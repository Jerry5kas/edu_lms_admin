<x-layouts.main>
    <div class="bg-gray-50 flex justify-center items-center min-h-screen px-4">
        <div class="bg-white shadow-xl rounded-2xl p-6 md:p-8 w-full max-w-4xl">
            <div class="flex flex-col md:flex-row md:items-center gap-6">

                <!-- Avatar -->
                <div class="flex flex-col items-center md:items-start">
                    <img src="{{ Auth::check() && Auth::user()->profile
                        ? asset('storage/profile_images/' . Auth::user()->profile)
                        : asset('images/default-profile.png') }}"
                         alt="Profile"
                         class="w-24 h-24 rounded-full object-cover mb-2 border shadow-md" />

                    <h2 class="text-lg font-semibold text-gray-800">
                        {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                    </h2>

                    <!-- Upload Profile Pic -->
                    <form action="{{ route('auth.profile.edit') }}" method="POST" enctype="multipart/form-data"
                          class="flex items-center space-x-2 mt-2">
                        @csrf
                        <label class="cursor-pointer flex items-center space-x-2 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-full shadow-sm transition">
                            <!-- Heroicon: Camera -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 8.25v7.5A2.25 2.25 0 004.5 18h15a2.25 2.25 0 002.25-2.25v-7.5A2.25 2.25 0 0019.5 6h-2.878a1.5 1.5 0 01-1.06-.44l-.94-.94a1.5 1.5 0 00-1.06-.44h-.878a1.5 1.5 0 00-1.06.44l-.94.94a1.5 1.5 0 01-1.06.44H4.5A2.25 2.25 0 002.25 8.25z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-sm text-gray-700">Change</span>
                            <input type="file" name="profile" accept="image/*" class="hidden" onchange="this.form.submit()">
                        </label>
                    </form>
                </div>

                <!-- Profile Info -->
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                    </h2>
                    <p class="text-gray-500 mt-1 text-sm">
                        Joined Unacademy in {{ date('Y') }}
                    </p>

                    <!-- Stats -->
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-gray-100 px-6 py-3 rounded-lg shadow flex flex-col items-center">
                            <p class="text-lg font-bold text-gray-800">208</p>
                            <p class="text-gray-500 text-sm flex items-center space-x-1">
                                <!-- Heroicon: Play -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.25 5.653c0-.856.917-1.397 1.667-.944l11.54 6.846c.737.437.737 1.451 0 1.888L6.917 20.29c-.75.453-1.667-.088-1.667-.944V5.653z" />
                                </svg>
                                <span>Watch mins</span>
                            </p>
                        </div>

                        <div class="bg-gray-100 px-6 py-3 rounded-lg shadow flex flex-col items-center">
                            <p class="text-lg font-bold text-gray-800">1</p>
                            <p class="text-gray-500 text-sm flex items-center space-x-1">
                                <!-- Heroicon: User -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0v.75H4.5v-.75z" />
                                </svg>
                                <span>Following</span>
                            </p>
                        </div>

                        <div class="bg-gray-100 px-6 py-3 rounded-lg shadow flex flex-col items-center">
                            <p class="text-lg font-bold text-gray-800">2</p>
                            <p class="text-gray-500 text-sm flex items-center space-x-1">
                                <!-- Heroicon: Academic Cap -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14v7m0-7L3 9m9 5l9-5m-9 5v7" />
                                </svg>
                                <span>Knowledge Hats</span>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layouts.main>
