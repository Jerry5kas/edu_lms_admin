@if(auth()->check() && (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin')))
<div class="bg-gray-100 border-b border-gray-200 mb-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center space-x-8">
                <h2 class="text-lg font-semibold text-gray-900">Admin Panel</h2>
                <nav class="flex space-x-4">
                    @can('roles.view')
                    <a href="{{ route('admin.roles.index') }}"
                       class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Roles
                    </a>
                    @endcan

                    @can('permissions.view')
                    <a href="{{ route('admin.permissions.index') }}"
                       class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Permissions
                    </a>
                    @endcan

                                        @can('users.view')
                    <a href="{{ route('admin.users.index') }}" 
                       class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        User Management
                    </a>
                    @endcan
                    
                    @can('dashboard.access')
                    <a href="{{ route('dashboard.index') }}" 
                       class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Dashboard
                    </a>
                    @endcan
                </nav>
            </div>

            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">
                    Logged in as: {{ auth()->user()->name }}
                    <span class="ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                        {{ auth()->user()->roles->first()->name ?? 'No Role' }}
                    </span>
                </span>
            </div>
        </div>
    </div>
</div>
@endif
