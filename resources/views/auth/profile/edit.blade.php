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
                <!-- Avatar -->
                <div class="flex flex-col items-center md:items-start">
                    <img src="{{ Auth::check() && Auth::user()->profile
                        ? asset('storage/profile_images/' . Auth::user()->profile)
                        : 'https://via.placeholder.com/150/3B82F6/FFFFFF?text=' . substr(Auth::user()->name ?? 'U', 0, 1) }}"
                         alt="Profile"
                         class="w-24 h-24 rounded-full object-cover mb-2 border">

                    <form action="{{ route('auth.profile.update') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
                        @csrf
                        <label class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-white px-6 py-2 rounded-full transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25v7.5a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-2.878a1.5 1.5 0 01-1.06-.44l-.94-.94A1.5 1.5 0 0012.439 4.5h-.878a1.5 1.5 0 00-1.06.44l-.94.94a1.5 1.5 0 01-1.06.44H5.25A2.25 2.25 0 002.25 8.25z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <input type="file" name="profile" accept="image/*" class="hidden" onchange="this.form.submit()">
                        </label>
                    </form>
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
