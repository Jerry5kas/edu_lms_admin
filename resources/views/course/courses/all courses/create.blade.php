<x-layouts.main>
    <div class="max-w-3xl mx-auto bg-white shadow rounded-2xl p-6">
        <h1 class="text-2xl font-bold mb-6">Create Course</h1>

        <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Title -->
            <div>
                <label class="block font-medium mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <!-- Subtitle -->
            <div>
                <label class="block font-medium mb-1">Subtitle</label>
                <input type="text" name="subtitle" value="{{ old('subtitle') }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <!-- Slug -->
            <div>
                <label class="block font-medium mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <!-- Description -->
            <div>
                <label class="block font-medium mb-1">Description</label>
                <textarea name="description" rows="4"
                          class="w-full border rounded-lg px-3 py-2">{{ old('description') }}</textarea>
            </div>

            <!-- Language -->
            <div>
                <label class="block font-medium mb-1">Language</label>
                <select name="language" class="w-full border rounded-lg px-3 py-2">
                    <option value="de" {{ old('language') == 'de' ? 'selected' : '' }}>German</option>
                    <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>English</option>
                </select>
            </div>

            <!-- Level -->
            <div>
                <label class="block font-medium mb-1">Level</label>
                <select name="level" class="w-full border rounded-lg px-3 py-2">
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
            </div>

            <!-- Price -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Price (in cents)</label>
                    <input type="number" name="price_cents" value="{{ old('price_cents', 0) }}"
                           class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block font-medium mb-1">Currency</label>
                    <input type="text" name="currency" value="{{ old('currency', 'EUR') }}"
                           class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>

            <!-- Thumbnail -->
            <div>
                <label class="block font-medium mb-1">Thumbnail</label>
                <div x-data="{ preview: null }">
                    <input type="file" name="thumbnail_path" accept="image/*"
                           class="w-full border rounded-lg px-3 py-2"
                           @change="preview = URL.createObjectURL($event.target.files[0])">

                    <!-- Preview -->
                    <div x-show="preview" class="mt-2">
                        <img :src="preview" alt="Thumbnail Preview"
                             class="w-32 h-24 object-cover rounded-lg border">
                    </div>
                </div>
            </div>

            <!-- Trailer URL -->
            <div>
                <label class="block font-medium mb-1">Trailer URL</label>
                <input type="url" name="trailer_url" value="{{ old('trailer_url') }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <!-- Categories -->
            <div>
                <label class="block font-medium mb-1">Categories</label>
                <select name="categories[]" multiple class="w-full border rounded-lg px-3 py-2">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ in_array($cat->id, old('categories', [])) ? 'selected' : '' }}>
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
                            {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Created By</label>
                <p class="px-3 py-2 bg-gray-100 rounded-lg">
                    {{ Auth::user()->name ?? 'N/A' }}
                </p>
            </div>


            <!-- Publish -->
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                <label>Publish immediately</label>
            </div>

            <!-- Published At -->
            <div>
                <label class="block font-medium mb-1">Publish Date</label>
                <input type="datetime-local" name="published_at"
                       value="{{ old('published_at') }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Save Course
                </button>
            </div>
        </form>
    </div>
</x-layouts.main>
