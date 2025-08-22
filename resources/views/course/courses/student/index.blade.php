<x-layouts.main>
    <div class="bg-white border rounded-2xl shadow p-6"
         x-data="{ courses: [1, 2, 3] }">

        <!-- 🔹 Top Bar -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
            <!-- Heading -->
            <h1 class="text-2xl font-bold text-gray-800">Student Courses</h1>

            <!-- Add Button -->
            <a href="{{route('courses.create')}}"
                class="flex items-center gap-2 px-4 py-2 text-base font-medium text-white bg-blue-600 rounded-full shadow hover:bg-blue-700 transition">
                <!-- Heroicon: Plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4v16m8-8H4"/>
                </svg>
                Add New Course
            </a>
        </div>

        <!-- Grid Container -->
        <div class="grid gap-6 sm:grid-cols-3 lg:grid-cols-3">
            @foreach($courses as $course)
            <!-- Course Card -->
            <div class="bg-white rounded-2xl shadow p-4 flex flex-col transition hover:shadow-xl">

                <!-- Top Image -->
                @if($course->thumbnail_path)
                    <img src="{{ asset('storage/' . $course->thumbnail_path) }}"
                         alt="{{ $course->title }}"
                         class="w-full h-40 object-cover rounded-lg mb-4">
                @else
                    <div class="w-full h-40 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
                <!-- Tag -->
                @if($course->categories->count() > 0)
                    <span class="inline-block px-3 py-1 text-sm rounded-full bg-green-100 text-green-600 font-medium mb-2">
                        {{ $course->categories->first()->name }}
                    </span>
                @else
                    <span class="inline-block px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-600 font-medium mb-2">
                        Uncategorized
                    </span>
                @endif

                <!-- Title -->
                <h2 class="text-lg font-bold text-gray-800 mb-2">
                    {{ $course->title }}
                </h2>

                <!-- Creator -->
                <div class="flex items-center gap-2 mb-3">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Creator"
                         class="w-8 h-8 rounded-full">
                    <p class="text-sm text-gray-600">
                        Created by <span class="font-semibold text-gray-800">{{ $course->id }}</span>
                    </p>
                </div>

                <!-- Lessons & Hours -->
                <div class="flex items-center justify-between text-sm text-gray-600 border-t border-b py-2 mb-3">
                    <div class="flex items-center gap-1">
                        <!-- Heroicon: Video Camera -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M4 6h8a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z"/>
                        </svg>
                        24 Lessons
                    </div>
                    <div class="flex items-center gap-1">
                        <!-- Heroicon: Clock -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        40 Hours
                    </div>
                </div>

                <!-- Rating + Button -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center text-sm text-gray-700">
                        <!-- Heroicon: Star -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.356 4.177a1 1 0 00.95.69h4.393c.969 0 1.371 1.24.588 1.81l-3.562 2.585a1 1 0 00-.364 1.118l1.357 4.177c.3.921-.755 1.688-1.54 1.118l-3.562-2.585a1 1 0 00-1.175 0l-3.562 2.585c-.785.57-1.84-.197-1.54-1.118l1.357-4.177a1 1 0 00-.364-1.118L2.11 9.604c-.783-.57-.38-1.81.588-1.81h4.393a1 1 0 00.95-.69l1.008-3.177z"/>
                        </svg>
                        <span class="ml-1 font-medium">4.9</span>
                        <span class="ml-1 text-gray-500">(12k)</span>
                    </div>
                    <a href="{{ route('courses.edit', $course) }}"
                       class="px-4 py-2 text-sm font-medium text-blue-600 border border-blue-600 rounded-full hover:bg-blue-50 transition">
                        View Details
                    </a>
                </div>
            </div>
            @endforeach
    </div>
</x-layouts.main>
