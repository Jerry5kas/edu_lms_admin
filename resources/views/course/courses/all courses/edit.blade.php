<x-layouts.main>
    <div class="max-w-3xl mx-auto bg-white shadow rounded-2xl p-6">
        <h1 class="text-2xl font-bold mb-6">Edit Course</h1>

        <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label class="block font-medium mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title', $course->title) }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <!-- Subtitle -->
            <div>
                <label class="block font-medium mb-1">Subtitle</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $course->subtitle) }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <!-- Slug -->
            <div>
                <label class="block font-medium mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $course->slug) }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <!-- Description -->
            <div>
                <label class="block font-medium mb-1">Description</label>
                <textarea name="description" rows="4"
                          class="w-full border rounded-lg px-3 py-2">{{ old('description', $course->description) }}</textarea>
            </div>

            <!-- Language -->
            <div>
                <label class="block font-medium mb-1">Language</label>
                <select name="language" class="w-full border rounded-lg px-3 py-2">
                    <option value="de" {{ old('language', $course->language) == 'de' ? 'selected' : '' }}>German</option>
                    <option value="en" {{ old('language', $course->language) == 'en' ? 'selected' : '' }}>English</option>
                </select>
            </div>

            <!-- Level -->
            <div>
                <label class="block font-medium mb-1">Level</label>
                <select name="level" class="w-full border rounded-lg px-3 py-2">
                    <option value="beginner" {{ old('level', $course->level) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                    <option value="intermediate" {{ old('level', $course->level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                    <option value="advanced" {{ old('level', $course->level) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                </select>
            </div>

            <!-- Price -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Price (in cents)</label>
                    <input type="number" name="price_cents" value="{{ old('price_cents', $course->price_cents) }}"
                           class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block font-medium mb-1">Currency</label>
                    <input type="text" name="currency" value="{{ old('currency', $course->currency) }}"
                           class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>

            <!-- Thumbnail -->
            <div>
                <label class="block font-medium mb-1">Thumbnail</label>
                <div x-data="{ preview: null }">
                    <!-- Current Thumbnail -->
                    @if($course->thumbnail_path)
                        <div class="mb-2">
                            <p class="text-sm text-gray-600 mb-2">Current Thumbnail:</p>
                            <img src="{{ asset('storage/' . $course->thumbnail_path) }}"
                                 alt="Current Thumbnail"
                                 class="w-32 h-24 object-cover rounded-lg border">
                        </div>
                    @endif

                    <input type="file" name="thumbnail_path" accept="image/*"
                           class="w-full border rounded-lg px-3 py-2"
                           @change="preview = URL.createObjectURL($event.target.files[0])">

                    <!-- New Preview -->
                    <div x-show="preview" class="mt-2">
                        <p class="text-sm text-gray-600 mb-2">New Thumbnail Preview:</p>
                        <img :src="preview" alt="Thumbnail Preview"
                             class="w-32 h-24 object-cover rounded-lg border">
                    </div>
                </div>
            </div>

            <!-- Trailer URL -->
            <div>
                <label class="block font-medium mb-1">Trailer URL</label>
                <input type="url" name="trailer_url" value="{{ old('trailer_url', $course->trailer_url) }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <!-- Categories -->
            <div>
                <label class="block font-medium mb-1">Categories</label>
                <select name="categories[]" multiple class="w-full border rounded-lg px-3 py-2">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ in_array($cat->id, old('categories', $selectedCategories)) ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tags -->
            <div>
                <label class="block font-medium mb-1">Tags</label>
                <select name="tags[]" multiple class="w-full border rounded-lg px-3 py-2">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}"
                            {{ in_array($tag->id, old('tags', $selectedTags)) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Created By</label>
                <p class="px-3 py-2 bg-gray-100 rounded-lg">
                    {{ $course->creator?->id ?? 'N/A' }}
                </p>
            </div>

            <!-- Publish -->
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" value="1"
                       {{ old('is_published', $course->is_published) ? 'checked' : '' }}>
                <label>Publish immediately</label>
            </div>

            <!-- Published At -->
            <div>
                <label class="block font-medium mb-1">Publish Date</label>
                <input type="datetime-local" name="published_at"
                       value="{{ old('published_at', $course->published_at ? $course->published_at->format('Y-m-d\TH:i') : '') }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('courses.index') }}"
                   class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update Course
                </button>
            </div>
        </form>
    </div>
</x-layouts.main>
