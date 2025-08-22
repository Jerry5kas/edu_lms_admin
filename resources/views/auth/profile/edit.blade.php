<x-layouts.main>
    <div class="bg-gray-50 flex justify-center items-center min-h-screen px-4">
        <div class="bg-white shadow-xl rounded-2xl p-6 md:p-8 w-full max-w-4xl">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex flex-col md:flex-row md:items-center gap-6">
{{--                <!-- Avatar -->--}}
{{--                <div class="flex flex-col items-center md:items-start">--}}
{{--                    <img src="{{ Auth::check() && Auth::user()->profile--}}
{{--                        ? asset('storage/profile_images/' . Auth::user()->profile)--}}
{{--                        : 'https://via.placeholder.com/150/3B82F6/FFFFFF?text=' . substr(Auth::user()->name ?? 'U', 0, 1) }}"--}}
{{--                         alt="Profile"--}}
{{--                         class="w-24 h-24 rounded-full object-cover mb-2 border">--}}

                    <!-- Left Panel: Profile Image & Upload -->
                    <div class="flex flex-col items-center md:items-start">
                        <div x-data="{ preview: '{{ Auth::user()->profile ? asset('storage/profile_images/' . Auth::user()->profile) : '' }}' }" class="relative">
                            <img :src="preview || 'https://via.placeholder.com/150/3B82F6/FFFFFF?text={{ substr(Auth::user()->name ?? 'U', 0, 1) }}'"
                                 alt="Profile"
                                 class="w-28 h-28 rounded-full object-cover border-2 border-blue-500 shadow-md">

                            <!-- Upload Button -->
                            <form action="{{ route('auth.profile.update') }}" method="POST" enctype="multipart/form-data" class="absolute bottom-0 right-0">
                                @csrf
                                <label class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow-lg transition flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h10a4 4 0 004-4v-7a4 4 0 00-4-4H7a4 4 0 00-4 4v7z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11v6m3-3H9" />
                                    </svg>
                                    <input type="file" name="profile" accept="image/*" class="hidden" onchange="this.form.submit();">
                                </label>
                            </form>
                        </div>

                    </div>

                <!-- Profile Info -->
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-2xl font-bold text-gray-800">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</h2>
                    <p class="text-gray-500 mt-1">Joined Unacademy in {{ date('Y') }}</p>

                    <!-- Stats -->
                    <div class="mt-6 flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                        <div class="bg-gray-100 px-6 py-3 rounded-lg shadow text-center">
                            <p class="text-lg font-bold text-gray-800">208</p>
                            <p class="text-gray-500 text-sm">Watch mins</p>
                        </div>
                        <div class="bg-gray-100 px-6 py-3 rounded-lg shadow text-center">
                            <p class="text-lg font-bold text-gray-800">1</p>
                            <p class="text-gray-500 text-sm">Following</p>
                        </div>
                        <div class="bg-gray-100 px-6 py-3 rounded-lg shadow text-center">
                            <p class="text-lg font-bold text-gray-800">2</p>
                            <p class="text-gray-500 text-sm">Knowledge Hats</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>
