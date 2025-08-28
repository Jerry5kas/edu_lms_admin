<x-layouts.main>
    <div class="bg-white rounded-2xl shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Role: {{ $role->name }}</h1>
            <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Back to Roles
            </a>
        </div>

        @if($role->name === 'Super Admin')
            <div class="mb-6 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg">
                <strong>Note:</strong> The Super Admin role cannot be modified. This role has all permissions by default.
            </div>
        @endif

        <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Role Name</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $role->name) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                       placeholder="e.g., Content Manager" 
                       {{ $role->name === 'Super Admin' ? 'disabled' : 'required' }}>
                @error('name') 
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-4">Permissions</label>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($permissions as $group => $perms)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-gray-900 mb-3 capitalize">{{ $group }}</h3>
                            <div class="space-y-2">
                                @foreach($perms as $perm)
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $perm->name }}"
                                               {{ in_array($perm->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}
                                               {{ $role->name === 'Super Admin' ? 'disabled' : '' }}
                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-700">{{ $perm->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('permissions') 
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t">
                <a href="{{ route('admin.roles.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                        {{ $role->name === 'Super Admin' ? 'disabled' : '' }}>
                    Update Role
                </button>
            </div>
        </form>
    </div>
</x-layouts.main>
