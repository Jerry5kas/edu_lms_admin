 <x-layouts.main>
    <div class="bg-white p-6">
        <div class="w-full max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">{{ $quiz->title }}</h1>
                <p class="text-gray-600">Quiz details and settings</p>
            </div>

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('quizzes.index') }}"
                   class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    ← Back to Quizzes
                </a>
            </div>

            <!-- Quiz Information -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Quiz Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Quiz Information</h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Title</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $quiz->title }}</p>
                            </div>

                            @if($quiz->description)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $quiz->description }}</p>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Lesson</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $quiz->lesson->title ?? 'Unknown Lesson' }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Course</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $quiz->lesson->course->title ?? 'Unknown Course' }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <div class="mt-1">
                                    @if($quiz->isActive())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Created</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $quiz->created_at->format('M d, Y H:i') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $quiz->updated_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Settings -->
                    <div class="bg-white rounded-lg shadow p-6 mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Quiz Settings</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Time Limit</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        @if($quiz->getTimeLimit())
                                            {{ $quiz->getTimeLimit() }} minutes
                                        @else
                                            <span class="text-gray-500">No time limit</span>
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Passing Score</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $quiz->getPassingScore() }}%</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Maximum Attempts</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $quiz->getMaxAttempts() }} attempts</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Shuffle Questions</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        @if($quiz->shouldShuffleQuestions())
                                            <span class="text-green-600">Enabled</span>
                                        @else
                                            <span class="text-gray-500">Disabled</span>
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Show Results</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        @if($quiz->shouldShowResults())
                                            <span class="text-green-600">Enabled</span>
                                        @else
                                            <span class="text-gray-500">Disabled</span>
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Allow Review</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        @if($quiz->allowReview())
                                            <span class="text-green-600">Enabled</span>
                                        @else
                                            <span class="text-gray-500">Disabled</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Stats -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Stats</h3>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Status</span>
                                <span class="text-sm font-medium text-gray-900">
                                    @if($quiz->isActive())
                                        <span class="text-green-600">Active</span>
                                    @else
                                        <span class="text-red-600">Inactive</span>
                                    @endif
                                </span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Time Limit</span>
                                <span class="text-sm font-medium text-gray-900">
                                    @if($quiz->getTimeLimit())
                                        {{ $quiz->getTimeLimit() }} min
                                    @else
                                        Unlimited
                                    @endif
                                </span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Passing Score</span>
                                <span class="text-sm font-medium text-gray-900">{{ $quiz->getPassingScore() }}%</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Max Attempts</span>
                                <span class="text-sm font-medium text-gray-900">{{ $quiz->getMaxAttempts() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>

                        <div class="space-y-3">
                            <a href="{{ route('quizzes.edit', $quiz) }}"
                               class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Quiz
                            </a>

                            <form action="{{ route('quizzes.toggle-active', $quiz) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ $quiz->isActive() ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>

                            <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this quiz? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete Quiz
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Related Information -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Related Information</h3>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Lesson</label>
                                <a href="{{ route('lesson-views.show', $quiz->lesson) }}"
                                   class="mt-1 text-sm text-blue-600 hover:text-blue-800">
                                    {{ $quiz->lesson->title ?? 'Unknown Lesson' }}
                                </a>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Course</label>
                                <a href="{{ route('courses.show', $quiz->lesson->course) }}"
                                   class="mt-1 text-sm text-blue-600 hover:text-blue-800">
                                    {{ $quiz->lesson->course->title ?? 'Unknown Course' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Future: Quiz Questions Section -->
            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Quiz Questions</h3>
                    <span class="text-sm text-gray-500">Coming soon...</span>
                </div>

                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No questions yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Question management will be available in the next update.</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>
