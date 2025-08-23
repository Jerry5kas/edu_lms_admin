<x-layouts.main>
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">
            Add New Lesson ({{ $section->title }})
        </h1>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Lesson Create Form -->
        <form action="{{ route('courses.sections.lessons.store', [$course, $section]) }}"
              method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label class="block font-medium text-gray-700">Title</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200" required>
            </div>

            <!-- Content Type -->
            <div>
                <label class="block font-medium text-gray-700">Content Type</label>
                <select name="content_type" id="content_type"
                        class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200" required>
                    <option value="">-- Select Type --</option>
                    <option value="text" {{ old('content_type') == 'text' ? 'selected' : '' }}>Text</option>
                    <option value="video" {{ old('content_type') == 'video' ? 'selected' : '' }}>Video</option>
                    <option value="pdf" {{ old('content_type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                    <option value="file" {{ old('content_type') == 'file' ? 'selected' : '' }}>File</option>
                </select>
            </div>

            <!-- Text Content -->
            <div id="text_content" class="hidden">
                <label class="block font-medium text-gray-700">Content</label>
                <textarea name="content" rows="5"
                          class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">{{ old('content') }}</textarea>
            </div>

            <!-- Video Fields -->
            <div id="video_fields" class="hidden space-y-4">
                <div>
                    <label class="block font-medium text-gray-700">Video Provider</label>
                    <input type="text" name="video_provider" value="{{ old('video_provider') }}"
                           placeholder="e.g., YouTube, Vimeo"
                           class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                </div>
                <div>
                    <label class="block font-medium text-gray-700">Video Reference</label>
                    <input type="text" name="video_ref" value="{{ old('video_ref') }}"
                           placeholder="e.g., Video URL or ID"
                           class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                </div>
                <div>
                    <label class="block font-medium text-gray-700">Duration</label>
                    <input type="text" name="duration" value="{{ old('duration') }}"
                           class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                </div>
                <div>
                    <label class="block font-medium text-gray-700">description</label>
                    <textarea name="description" rows="5"
                              class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- File Upload -->
            <div id="file_upload" class="hidden">
                <label class="block font-medium text-gray-700">Upload File (PDF, DOC, PPT, etc.)</label>
                <input type="file" name="attachment"
                       class="w-full mt-1 border rounded-lg px-3 py-2">
            </div>



            <!-- Sort Order -->
            <div>
                <label class="block font-medium text-gray-700">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            <!-- Publish Checkbox -->
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                <label>Publish immediately</label>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('courses.sections.lessons.index', [$course, $section]) }}"
                   class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Save Lesson
                </button>
            </div>
        </form>
    </div>

    <!-- Alpine.js for Dynamic Fields -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('content_type');
            const textContent = document.getElementById('text_content');
            const videoFields = document.getElementById('video_fields');
            const fileUpload = document.getElementById('file_upload');

            function toggleFields() {
                textContent.classList.add('hidden');
                videoFields.classList.add('hidden');
                fileUpload.classList.add('hidden');

                if (typeSelect.value === 'text') {
                    textContent.classList.remove('hidden');
                } else if (typeSelect.value === 'video') {
                    videoFields.classList.remove('hidden');
                } else if (typeSelect.value === 'pdf' || typeSelect.value === 'file') {
                    fileUpload.classList.remove('hidden');
                }
            }

            typeSelect.addEventListener('change', toggleFields);
            toggleFields(); // Run on page load
        });
    </script>
</x-layouts.main>
