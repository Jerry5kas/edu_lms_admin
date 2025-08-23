<x-layouts.main>
    <div class="bg-white p-6">
        <div class="w-full max-w-7xl mx-auto">
            <!-- Course Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit Section</h1>
                <p class="text-gray-600">{{ $course->title }} - {{ $section->title }}</p>
            </div>
            
            <!-- Form -->
            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('courses.sections.update', [$course, $section]) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Section Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $section->title) }}"
                               class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                               placeholder="Enter section title"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                            Sort Order
                        </label>
                        <input type="number" 
                               id="sort_order" 
                               name="sort_order" 
                               value="{{ old('sort_order', $section->sort_order) }}"
                               min="1"
                               class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sort_order') border-red-500 @enderror"
                               placeholder="Enter sort order">
                        <p class="mt-1 text-sm text-gray-500">Lower numbers appear first</p>
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Section Stats -->
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Section Statistics</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Lessons:</span>
                                <span class="font-medium text-gray-900">{{ $section->lessons_count }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Total Duration:</span>
                                <span class="font-medium text-gray-900">{{ $section->total_duration }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Created:</span>
                                <span class="font-medium text-gray-900">{{ $section->created_at->format('M d, Y') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Last Updated:</span>
                                <span class="font-medium text-gray-900">{{ $section->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                                class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                            Update Section
                        </button>
                        <a href="{{ route('courses.sections.index', $course) }}"
                           class="px-4 py-2 text-gray-700 bg-gray-300 rounded-lg hover:bg-gray-400 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.main>
