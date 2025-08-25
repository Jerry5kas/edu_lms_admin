<x-layouts.main>
    <div class="bg-white border rounded-2xl shadow p-6">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-6">
            <a href="{{ route('courses.index') }}" class="hover:text-blue-600">Courses</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-800 font-medium">{{ $course->title }}</span>
        </div>

        <!-- Course Header -->
        <div class="flex flex-col lg:flex-row gap-6 mb-8">
            <!-- Course Thumbnail -->
            <div class="lg:w-1/3">
                @if($course->thumbnail_path)
                    <img src="{{ asset('storage/' . $course->thumbnail_path) }}"
                         alt="{{ $course->title }}"
                         class="w-full h-64 object-cover rounded-2xl shadow-lg">
                @else
                    <div class="w-full h-64 bg-gray-200 rounded-2xl flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Course Info -->
            <div class="lg:w-2/3">
                <!-- Title & Subtitle -->
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $course->title }}</h1>
                @if($course->subtitle)
                    <p class="text-lg text-gray-600 mb-4">{{ $course->subtitle }}</p>
                @endif

                <!-- Status Badge -->
                <div class="mb-4">
                    @if($course->is_published)
                        <span class="inline-block px-3 py-1 text-sm rounded-full bg-green-100 text-green-600 font-medium">
                            Published
                        </span>
                    @else
                        <span class="inline-block px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-600 font-medium">
                            Draft
                        </span>
                    @endif
                </div>

                <!-- Categories & Tags -->
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($course->categories as $category)
                        <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-600 font-medium">
                            {{ $category->name }}
                        </span>
                    @endforeach
                    @foreach($course->tags as $tag)
                        <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-600 font-medium">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>

                <!-- Course Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $course->sections->count() }}</div>
                        <div class="text-sm text-gray-600">Sections</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $course->sections->sum(function($section) { return $section->lessons->count(); }) }}</div>
                        <div class="text-sm text-gray-600">Lessons</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ ucfirst($course->level) }}</div>
                        <div class="text-sm text-gray-600">Level</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-orange-600">{{ strtoupper($course->language) }}</div>
                        <div class="text-sm text-gray-600">Language</div>
                    </div>
                </div>

                <!-- Price -->
                @if($course->price_cents > 0)
                    <div class="mb-4">
                        <span class="text-2xl font-bold text-gray-800">
                            {{ number_format($course->price_cents / 100, 2) }} {{ $course->currency }}
                        </span>
                    </div>
                @endif

                <!-- Creator Info -->
                <div class="flex items-center gap-3 mb-6">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Creator"
                         class="w-10 h-10 rounded-full">
                    <div>
                        <p class="text-sm text-gray-600">Created by</p>
                        <p class="font-medium text-gray-800">{{ $course->creator->name ?? 'Unknown' }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <a href="{{ route('courses.edit', $course) }}"
                       class="flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Course
                    </a>
                    <a href="{{ route('courses.sections.index', $course) }}"
                       class="flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Manage Sections
                    </a>
                    <a href="{{ route('courses.progress-view', $course) }}"
                       class="flex items-center gap-2 px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        View Progress
                    </a>
                </div>
            </div>
        </div>

        <!-- Course Description -->
        @if($course->description)
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Description</h2>
                <div class="prose max-w-none">
                    {!! nl2br(e($course->description)) !!}
                </div>
            </div>
        @endif

        <!-- Course Sections -->
        @if($course->sections->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Course Content</h2>
                <div class="space-y-3">
                    @foreach($course->sections->sortBy('sort_order') as $section)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $section->title }}</h3>
                                    <p class="text-sm text-gray-600">{{ $section->lessons->count() }} lessons</p>
                                </div>
                                <div class="text-sm text-gray-500">
                                    @if($section->lessons->count() > 0)
                                        {{ $section->lessons->sum('duration_minutes') ?? 0 }} min
                                    @else
                                        0 min
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Course Details -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Additional Info -->
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-4">Course Details</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Level:</span>
                        <span class="font-medium">{{ ucfirst($course->level) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Language:</span>
                        <span class="font-medium">{{ strtoupper($course->language) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Created:</span>
                        <span class="font-medium">{{ $course->created_at->format('M d, Y') }}</span>
                    </div>
                    @if($course->published_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Published:</span>
                            <span class="font-medium">{{ $course->published_at->format('M d, Y') }}</span>
                        </div>
                    @endif
                    @if($course->trailer_url)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Trailer:</span>
                            <a href="{{ $course->trailer_url }}" target="_blank" class="text-blue-600 hover:underline">Watch Trailer</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Meta Information -->
            @if($course->meta)
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Additional Information</h2>
                    <div class="space-y-3">
                        @foreach($course->meta as $key => $value)
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                <span class="font-medium">{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.main>
