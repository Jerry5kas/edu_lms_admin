<x-layouts.main>
    <div class="bg-white rounded-2xl shadow p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">User Details: {{ $user->name }}</h1>
                <nav class="flex mt-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard.index') }}" class="text-red-600 hover:text-red-700">Dashboard</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <span class="mx-2 text-gray-400">/</span>
                                <a href="{{ route('admin.users.index') }}" class="text-red-600 hover:text-red-700">Admin Users</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <span class="mx-2 text-gray-400">/</span>
                                <span class="text-gray-500">User Details</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="flex items-center space-x-2">
                @can('users.edit')
                <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Edit User
                </a>
                @endcan
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Back to Users
                </a>
            </div>
        </div>

        <!-- User Information -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Basic Information -->
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Full Name</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Email Address</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Phone Number</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->phone_e164 ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Country</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->country_code ?? 'Not set' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Preferences</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Timezone</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->timezone ?? 'UTC' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Language</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->locale ?? 'en' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Marketing Opt-in</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->marketing_opt_in ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Roles and Permissions -->
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Assigned Roles</h3>
                    @if($user->roles->count() > 0)
                        <div class="space-y-2">
                            @foreach($user->roles as $role)
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg border">
                                    <div>
                                        <span class="font-medium text-gray-900">{{ $role->name }}</span>
                                        @if($role->name === 'Super Admin')
                                            <span class="ml-2 text-xs text-red-600">Full system access</span>
                                        @elseif($role->name === 'Admin')
                                            <span class="ml-2 text-xs text-blue-600">Administrative access</span>
                                        @elseif($role->name === 'Instructor')
                                            <span class="ml-2 text-xs text-green-600">Course management</span>
                                        @elseif($role->name === 'Manager')
                                            <span class="ml-2 text-xs text-purple-600">Operational management</span>
                                        @endif
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $role->permissions->count() }} permissions</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">No roles assigned</p>
                    @endif
                </div>

                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Account Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">User ID</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->id }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">UUID</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->uuid }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Email Verified</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->email_verified_at ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Phone Verified</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->phone_verified_at ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Last Login</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Created</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Last Updated</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between mt-8 pt-6 border-t">
            <div class="flex items-center space-x-2">
                @can('users.edit')
                <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Edit User
                </a>
                @endcan
                @can('users.edit')
                <a href="{{ route('admin.users.access.edit', $user) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    Manage Access
                </a>
                @endcan
            </div>
            <div class="flex items-center space-x-2">
                @can('users.delete')
                @if($user->id !== auth()->id() && !$user->hasRole('Super Admin'))
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Delete User
                    </button>
                </form>
                @endif
                @endcan
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Back to Users
                </a>
            </div>
        </div>
    </div>
</x-layouts.main>
