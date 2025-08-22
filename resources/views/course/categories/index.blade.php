<x-layouts.main>
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold mb-4">Course Categories</h2>

        <a href="{{ route('categories.create') }}"
           class="bg-blue-500 text-white px-4 py-2 rounded">Add New Category</a>
        </div>
        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 mt-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full mt-4 border border-gray-200">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-3 py-2 border">ID</th>
                <th class="px-3 py-2 border">Slug</th>
                <th class="px-3 py-2 border">Name</th>
                <th class="px-3 py-2 border">Parent</th>
                <th class="px-3 py-2 border">Sort Order</th>
                <th class="px-3 py-2 border">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $index => $cat)
                <tr>
                    <td class="border px-3 py-2">{{ $index + 1 }}</td>
                    <td class="border px-3 py-2">{{ $cat->slug }}</td>
                    <td class="border px-3 py-2">{{ $cat->name }}</td>
                    <td class="border px-3 py-2">{{ $cat->parent?->name ?? 'None' }}</td>
                    <td class="border px-3 py-2">{{ $cat->sort_order }}</td>
                    <td class="border px-3 py-2">
                        <a href="{{ route('categories.edit', $cat) }}"
                           class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>

                        <form action="{{ route('categories.destroy', $cat) }}" method="POST"
                              class="inline">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 text-white px-2 py-1 rounded"
                                    onclick="return confirm('Delete this category?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.main>
