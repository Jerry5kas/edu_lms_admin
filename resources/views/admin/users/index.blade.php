<x-layouts.main>
    <div class="bg-white rounded-2xl shadow p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Admin Users</h1>
                <nav class="flex mt-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard.index') }}" class="text-red-600 hover:text-red-700">Dashboard</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <span class="mx-2 text-gray-400">/</span>
                                <span class="text-gray-500">Admin Users</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            @can('users.create')
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Admin
            </a>
            @endcan
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center space-x-4 mb-6">
            <button class="px-4 py-2 bg-orange-500 text-white rounded-lg flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Admin List
            </button>
{{--            @can('users.create')--}}
{{--            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center">--}}
{{--                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>--}}
{{--                </svg>--}}
{{--                Create Admin--}}
{{--            </a>--}}
{{--            @endcan--}}
        </div>

        <!-- Messages -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filters and Search -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <label class="mr-2 text-sm text-gray-600">Show</label>
                    <select id="per_page" class="border border-gray-300 rounded px-2 py-1 text-sm" onchange="changePerPage(this.value)">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <label class="ml-2 text-sm text-gray-600">entries</label>
                </div>

                <div class="flex items-center">
                    <label class="mr-2 text-sm text-gray-600">Filter by Role:</label>
                    <select id="role_filter" class="border border-gray-300 rounded px-2 py-1 text-sm" onchange="filterByRole(this.value)">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center">
                <label class="mr-2 text-sm text-gray-600">Search:</label>
                <div class="relative">
                    <input type="text"
                           id="search"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search users..."
                           class="border border-gray-300 rounded px-3 py-1 text-sm pr-8">
                    <svg class="absolute right-2 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <form id="bulk-form" method="POST" action="{{ route('admin.users.bulk-delete') }}">
            @csrf
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-gray-500 border-b">
                        <tr>
                            <th class="py-3 px-4 font-medium w-12">
                                <input type="checkbox" id="select-all" class="rounded border-gray-300">
                            </th>
                            <th class="py-3 px-4 font-medium">Name</th>
                            <th class="py-3 px-4 font-medium">Email</th>
                            <th class="py-3 px-4 font-medium">Role</th>
                            <th class="py-3 px-4 font-medium w-32">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <input type="checkbox"
                                       name="user_ids[]"
                                       value="{{ $user->id }}"
                                       class="user-checkbox rounded border-gray-300"
                                       {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-red-600 hover:text-red-700 font-medium">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td class="py-3 px-4 text-gray-600">
                                {{ $user->email }}
                            </td>
                            <td class="py-3 px-4">
                                @if($user->roles->count() > 0)
                                    @foreach($user->roles as $role)
                                        <span class="inline-block px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full mr-1">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-gray-400 text-xs">No role assigned</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center space-x-2">
                                    @can('users.edit')
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="text-red-600 hover:text-red-700" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    @endcan
                                    @can('users.delete')
                                    @if($user->id !== auth()->id() && !$user->hasRole('Super Admin'))
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 px-4 text-center text-gray-500">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Bulk Actions -->
            @can('users.delete')
            <div class="mt-4 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <button type="submit"
                            id="bulk-delete-btn"
                            class="px-3 py-1 text-sm border border-red-300 text-red-600 rounded hover:bg-red-50 transition-colors hidden">
                        Delete Selected
                    </button>
                </div>
            </div>
            @endcan
        </form>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>

    <script>
        // Search functionality
        let searchTimeout;
        document.getElementById('search').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const search = this.value;
                const url = new URL(window.location);
                if (search) {
                    url.searchParams.set('search', search);
                } else {
                    url.searchParams.delete('search');
                }
                window.location = url;
            }, 500);
        });

        // Filter by role
        function filterByRole(role) {
            const url = new URL(window.location);
            if (role) {
                url.searchParams.set('role', role);
            } else {
                url.searchParams.delete('role');
            }
            window.location = url;
        }

        // Change per page
        function changePerPage(perPage) {
            const url = new URL(window.location);
            url.searchParams.set('per_page', perPage);
            window.location = url;
        }

        // Select all functionality
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.user-checkbox:not(:disabled)');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkDeleteButton();
        });

        // Individual checkbox change
        document.querySelectorAll('.user-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkDeleteButton);
        });

        function updateBulkDeleteButton() {
            const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');

            if (checkedBoxes.length > 0) {
                bulkDeleteBtn.classList.remove('hidden');
            } else {
                bulkDeleteBtn.classList.add('hidden');
            }
        }
    </script>
</x-layouts.main>
