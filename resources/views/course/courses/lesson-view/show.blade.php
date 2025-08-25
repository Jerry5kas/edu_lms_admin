<x-layouts.main>
    <div class="bg-white p-6">
        <div class="w-full max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Lesson View Details</h1>
                <p class="text-gray-600">Student progress information</p>
            </div>
            
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('lesson-views.index') }}" 
                   class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    ← Back to Lesson Views
                </a>
            </div>

            <!-- Details Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6">
                    <!-- User Information -->
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">User Information</h2>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                <div class="h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center text-white text-lg font-medium">
                                    {{ substr($lessonView->user->name ?? 'U', 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ $lessonView->user->name ?? 'Unknown User' }}</h3>
                                <p class="text-gray-500">{{ $lessonView->user->email ?? 'No email' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Lesson Information -->
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Lesson Information</h2>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Lesson Title:</span>
                                    <p class="text-gray-900">{{ $lessonView->lesson->title ?? 'Unknown Lesson' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Course:</span>
                                    <p class="text-gray-900">{{ $lessonView->lesson->course->title ?? 'Unknown Course' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Lesson Duration:</span>
                                    <p class="text-gray-900">{{ gmdate('H:i:s', $lessonView->lesson->duration_seconds ?? 0) }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Lesson Status:</span>
                                    <p class="text-gray-900">
                                        @if($lessonView->lesson->is_published ?? false)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Published
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Draft
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Information -->
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Progress Information</h2>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Seconds Watched:</span>
                                    <p class="text-gray-900">{{ number_format($lessonView->seconds_watched) }} seconds</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Last Position:</span>
                                    <p class="text-gray-900">{{ gmdate('H:i:s', $lessonView->last_position_seconds) }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Progress Percentage:</span>
                                    @php
                                        $progress = 0;
                                        if ($lessonView->lesson && $lessonView->lesson->duration_seconds > 0) {
                                            $progress = min(100, ($lessonView->seconds_watched / $lessonView->lesson->duration_seconds) * 100);
                                        }
                                    @endphp
                                    <p class="text-gray-900">{{ number_format($progress, 1) }}%</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Completion Status:</span>
                                    <p class="text-gray-900">
                                        @if($lessonView->completed_at)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Completed
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                In Progress
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <span>Progress</span>
                                    <span>{{ number_format($progress, 1) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-blue-600 h-3 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>

                            @if($lessonView->completed_at)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-green-800 font-medium">Lesson completed on {{ $lessonView->completed_at->format('M d, Y \a\t H:i') }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Timestamps</h2>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Created:</span>
                                    <p class="text-gray-900">{{ $lessonView->created_at->format('M d, Y \a\t H:i:s') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Last Updated:</span>
                                    <p class="text-gray-900">{{ $lessonView->updated_at->format('M d, Y \a\t H:i:s') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Note -->
                    <div class="pt-4 border-t">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-blue-800 text-sm">This lesson view is automatically generated and cannot be manually edited. Progress is tracked automatically when students watch lessons.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>
