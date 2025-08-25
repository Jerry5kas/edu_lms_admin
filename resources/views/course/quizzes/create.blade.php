<x-layouts.main>
    <div class="bg-white p-6">
        <div class="w-full max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Create Quiz</h1>
                <p class="text-gray-600">Add a new quiz to a lesson</p>
            </div>

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('quizzes.index') }}"
                   class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    ← Back to Quizzes
                </a>
            </div>

            <!-- Create Form -->
            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('quizzes.store') }}" method="POST">
                    @csrf

                    <!-- Basic Information -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="lesson_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Lesson <span class="text-red-500">*</span>
                                </label>
                                <select name="lesson_id" id="lesson_id" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select a lesson</option>
                                    @foreach($lessons as $lesson)
                                        <option value="{{ $lesson->id }}" {{ old('lesson_id') == $lesson->id ? 'selected' : '' }}>
                                            {{ $lesson->title }} ({{ $lesson->course->title }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('lesson_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Quiz Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Enter quiz title">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

{{--                        <div class="mt-6">--}}
{{--                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">--}}
{{--                                Description--}}
{{--                            </label>--}}
{{--                            <textarea name="description" id="description" rows="3"--}}
{{--                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"--}}
{{--                                      placeholder="Enter quiz description">{{ old('description') }}</textarea>--}}
{{--                            @error('description')--}}
{{--                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
                    </div>

                    <!-- Quiz Settings -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Quiz Settings</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="time_limit" class="block text-sm font-medium text-gray-700 mb-2">
                                    Time Limit (minutes)
                                </label>
                                <input type="number" name="time_limit" id="time_limit" value="{{ old('time_limit') }}" min="1"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="No limit">
                                @error('time_limit')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="passing_score" class="block text-sm font-medium text-gray-700 mb-2">
                                    Passing Score (%)
                                </label>
                                <input type="number" name="passing_score" id="passing_score" value="{{ old('passing_score', 70) }}" min="0" max="100"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('passing_score')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="max_attempts" class="block text-sm font-medium text-gray-700 mb-2">
                                    Max Attempts
                                </label>
                                <input type="number" name="max_attempts" id="max_attempts" value="{{ old('max_attempts', 3) }}" min="1"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('max_attempts')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Options -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Quiz Options</h3>

                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                    Active (available to students)
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="shuffle_questions" id="shuffle_questions" value="1" {{ old('shuffle_questions') ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="shuffle_questions" class="ml-2 block text-sm text-gray-900">
                                    Shuffle questions
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="show_results" id="show_results" value="1" {{ old('show_results', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="show_results" class="ml-2 block text-sm text-gray-900">
                                    Show results after completion
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="allow_review" id="allow_review" value="1" {{ old('allow_review', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="allow_review" class="ml-2 block text-sm text-gray-900">
                                    Allow review after completion
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('quizzes.index') }}"
                           class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Create Quiz
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.main>
