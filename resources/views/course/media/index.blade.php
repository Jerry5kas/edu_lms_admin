<x-layouts.main>
    <div class="bg-gray-50 min-h-screen p-4 md:p-6">
        <div class="max-w-7xl mx-auto">

            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Media Library</h1>
                <p class="text-gray-600">Manage your uploaded files</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Actions -->
            <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <a href="{{ route('courses.index') }}" class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200 text-gray-700 transition">
                    <!-- Back Arrow Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Courses
                </a>
                <a href="{{ route('media.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm font-medium">
                    <!-- Upload Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12v8m0-8l-3 3m3-3l3 3M12 4v8" />
                    </svg>
                    Upload Media
                </a>
            </div>

            <!-- Desktop Table -->
            <div class="hidden md:block bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full text-left text-gray-600">
                    <thead class="bg-gray-50 text-xs text-gray-700 uppercase">
                    <tr>
                        <th class="px-6 py-3">File</th>
                        <th class="px-6 py-3">Type</th>
                        <th class="px-6 py-3">Size</th>
                        <th class="px-6 py-3">Uploaded By</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($media as $file)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 flex items-center">
                                @if($file->is_image)
                                    <img src="{{ $file->url }}" alt="{{ $file->original_name }}" class="w-10 h-10 object-cover rounded mr-3">
                                @else
                                    <div class="w-10 h-10 bg-gray-100 rounded mr-3 flex items-center justify-center">
                                        <!-- Document Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $file->original_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $file->path }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $file->extension }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $file->size_formatted }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $file->user->name ?? 'Unknown' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $file->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right text-sm">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ $file->url }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                        <!-- Eye Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <!-- Delete Modal -->
                                    <div x-data="{ open: false }" class="inline">
                                        <button @click="open = true" class="text-red-500 hover:text-red-700">
                                            <!-- Trash Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                        <!-- Modal -->
                                        <div x-show="open" x-cloak x-transition.opacity
                                             class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                                            <div @click.away="open = false" class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
                                                <h2 class="text-lg font-medium text-gray-900 mb-4">Confirm Delete</h2>
                                                <p class="text-gray-600 mb-4">
                                                    Are you sure you want to delete <strong>{{ $file->original_name }}</strong>?
                                                </p>
                                                <div class="flex justify-end gap-2">
                                                    <button @click="open = false" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</button>
                                                    <form action="{{ route('media.destroy', $file->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No files uploaded yet.
                                <a href="{{ route('media.create') }}" class="text-blue-600 hover:underline">Upload your first file</a>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-4">
                @forelse($media as $file)
                    <div class="bg-white shadow rounded-lg p-4 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            @if($file->is_image)
                                <img src="{{ $file->url }}" alt="{{ $file->original_name }}" class="w-12 h-12 object-cover rounded">
                            @else
                                <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $file->original_name }}</div>
                                <div class="text-xs text-gray-500">{{ $file->size_formatted }} • {{ $file->extension }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ $file->url }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>

                            <!-- Delete Modal -->
                            <div x-data="{ open: false }" class="inline">
                                <button @click="open = true" class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>

                                <div x-show="open" x-cloak x-transition.opacity
                                     class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                                    <div @click.away="open = false" class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
                                        <h2 class="text-lg font-medium text-gray-900 mb-4">Confirm Delete</h2>
                                        <p class="text-gray-600 mb-4">Are you sure you want to delete <strong>{{ $file->original_name }}</strong>?</p>
                                        <div class="flex justify-end gap-2">
                                            <button @click="open = false" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</button>
                                            <form action="{{ route('media.destroy', $file->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500">
                        No files uploaded yet.
                        <a href="{{ route('media.create') }}" class="text-blue-600 hover:underline">Upload your first file</a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($media->hasPages())
                <div class="mt-6">
                    {{ $media->links() }}
                </div>
            @endif

        </div>
    </div>
</x-layouts.main>
