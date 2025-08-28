<x-layouts.main>
    <div class="bg-white rounded-2xl shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Manage Access for {{ $user->name }}</h1>
            <a href="{{ url()->previous() }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Back
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.access.update', $user) }}" class="space-y-8">
            @csrf @method('PUT')
            
            <!-- User Info -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-2">User Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Name:</span>
                        <span class="text-gray-900">{{ $user->name }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Email:</span>
                        <span class="text-gray-900">{{ $user->email }}</span>
                    </div>
                </div>
            </div>

            <!-- Roles Section -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Roles</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($roles as $role)
                        <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" 
                                   name="roles[]" 
                                   value="{{ $role->name }}"
                                   {{ in_array($role->name, old('roles', $userRoles)) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="font-medium text-gray-900">{{ $role->name }}</span>
                                @if($role->name === 'Super Admin')
                                    <span class="block text-xs text-red-600">Full system access</span>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('roles') 
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Direct Permissions Section -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Direct Permissions</h3>
                <p class="text-sm text-gray-600 mb-4">These permissions are assigned directly to the user, in addition to permissions from their roles.</p>
                
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($permissions as $group => $perms)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-3 capitalize">{{ $group }}</h4>
                            <div class="space-y-2">
                                @foreach($perms as $perm)
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $perm->name }}"
                                               {{ in_array($perm->name, old('permissions', $userDirectPermissions)) ? 'checked' : '' }}
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
                <a href="{{ url()->previous() }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-layouts.main>
