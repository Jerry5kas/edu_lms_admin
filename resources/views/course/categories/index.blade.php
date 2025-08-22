<x-layouts.main>
    <div class="bg-white rounded-xl p-6">
        <div class="w-full max-w-7xl mx-auto" x-data="{ open:false, selected:'Sort Order' }">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- 🔹 Top Bar -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
                <!-- Heading -->
                <h1 class="text-2xl font-bold text-gray-800">Categories</h1>

                <!-- Add Button -->
                <a href="{{route('categories.create')}}"
                   class="flex items-center gap-2 px-4 py-2 text-base font-medium text-white bg-blue-600 rounded-full shadow hover:bg-blue-700 transition">
                    <!-- Heroicon: Plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                    Add New Category
                </a>
            </div>
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
                <!-- Breadcrumb -->
                <div class="text-gray-500 text-sm">
                    Home / <span class="text-gray-900 font-medium">Course Categories</span>
                </div>

                <!-- Sort & Export -->
                <div class="flex items-center gap-3">
                    <!-- Sort Dropdown -->
                    <div class="relative" x-data="{open:false}">
                        <button @click="open=!open" class="flex items-center gap-1 px-3 py-2 border rounded-lg bg-white shadow hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 012 0v12a1 1 0 01-2 0V4zm6 4a1 1 0 012 0v8a1 1 0 01-2 0V8zm6-4a1 1 0 012 0v16a1 1 0 01-2 0V4zm6 8a1 1 0 012 0v4a1 1 0 01-2 0v-4z" />
                            </svg>
                            <span x-text="selected"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <!-- Dropdown -->
                        <div x-show="open" @click.away="open=false" class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-lg z-10" x-transition>
                            <ul class="text-sm text-gray-700">
                                <li><a href="#" @click="selected='Sort Order'; open=false" class="block px-4 py-2 hover:bg-gray-100">Sort Order</a></li>
                                <li><a href="#" @click="selected='Name'; open=false" class="block px-4 py-2 hover:bg-gray-100">Name</a></li>
                                <li><a href="#" @click="selected='Latest'; open=false" class="block px-4 py-2 hover:bg-gray-100">Latest</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Export Button -->
                    <button class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M4 12l8-8 8 8M12 4v12"/>
                        </svg>
                        Export
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3">ID</th>
                        <th class="p-3">Slug</th>
                        <th class="p-3">Name</th>
                        <th class="p-3">Description</th>
                        <th class="p-3">Parent</th>
                        <th class="p-3">Sort Order</th>
                        <th class="p-3">Created At</th>
                        <th class="p-3">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $index => $cat)
                        <tr>
                            <td class="border px-3 py-2">{{ $index + 1 }}</td>
                            <td class="border px-3 py-2">{{ $cat->slug }}</td>
                            <td class="border px-3 py-2">{{ $cat->name }}</td>
                            <td class="border px-3 py-2">{{ $cat->description }}</td>
                            <td class="border px-3 py-2">{{ $cat->parent?->name ?? 'None' }}</td>
                            <td class="border px-3 py-2">{{ $cat->sort_order }}</td>
                            <td class="border px-3 py-2">{{ $cat->created_at }}</td>
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

            <!-- Pagination -->
            <div class="flex justify-between items-center mt-4 text-sm text-gray-600">
                <p>Showing 1 to 10 of 12 entries</p>
                <div class="flex items-center gap-2">
                    <button class="px-3 py-1 border rounded hover:bg-gray-100">1</button>
                    <button class="px-3 py-1 border rounded hover:bg-gray-100">2</button>
                    <button class="px-3 py-1 border rounded hover:bg-gray-100">3</button>
                    ...
                    <button class="px-3 py-1 border rounded hover:bg-gray-100">10</button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>
