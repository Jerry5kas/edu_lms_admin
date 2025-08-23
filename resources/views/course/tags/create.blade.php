<x-layouts.main>
    <div class="max-w-3xl mx-auto bg-white shadow rounded-2xl p-6">
        <h1 class="text-2xl font-bold mb-6">Create Tag</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tags.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label class="block font-medium mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       placeholder="Enter tag name">
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('tags.index') }}" 
                   class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Create Tag
                </button>
            </div>
        </form>
    </div>
</x-layouts.main>
