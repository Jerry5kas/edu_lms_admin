<x-layouts.main>
    <div class="bg-white rounded-2xl shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Roles Management</h1>
            @can('roles.create')
            <a href="{{ route('admin.roles.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>New Role
            </a>
            @endcan
        </div>

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

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-left text-gray-500 border-b">
                    <tr>
                        <th class="py-3 px-4 font-medium">Name</th>
                        <th class="py-3 px-4 font-medium">Permissions</th>
                        <th class="py-3 px-4 font-medium">Users</th>
                        <th class="py-3 px-4 font-medium w-40">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($roles as $role)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center">
                                <span class="font-medium text-gray-900">{{ $role->name }}</span>
                                @if($role->name === 'Super Admin')
                                    <span class="ml-2 px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Protected</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="text-gray-600">{{ $role->permissions_count }} permissions</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="text-gray-600">{{ $role->users_count ?? 0 }} users</span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex gap-2">
                                @can('roles.edit')
                                <a href="{{ route('admin.roles.edit', $role) }}" 
                                   class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50 transition-colors">
                                    Edit
                                </a>
                                @endcan
                                @can('roles.delete')
                                @if($role->name !== 'Super Admin')
                                <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this role?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1 text-sm border border-red-300 text-red-600 rounded hover:bg-red-50 transition-colors">
                                        Delete
                                    </button>
                                </form>
                                @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 px-4 text-center text-gray-500">
                            No roles found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $roles->links() }}
        </div>
    </div>
</x-layouts.main>
