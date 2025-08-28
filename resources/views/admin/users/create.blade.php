<x-layouts.main>
    <div class="bg-white rounded-2xl shadow p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create New Admin User</h1>
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
                                <span class="text-gray-500">Create Admin</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Back to Users
            </a>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
            @csrf
            
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="Enter full name" 
                           required>
                    @error('name') 
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="Enter email address" 
                           required>
                    @error('email') 
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
                    @enderror
                </div>
            </div>

            <!-- Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="Enter password" 
                           required>
                    @error('password') 
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="Confirm password" 
                           required>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="phone_e164" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" 
                           id="phone_e164" 
                           name="phone_e164" 
                           value="{{ old('phone_e164') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="+1234567890">
                    @error('phone_e164') 
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label for="country_code" class="block text-sm font-medium text-gray-700 mb-2">Country Code</label>
                    <select id="country_code" 
                            name="country_code" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="US" {{ old('country_code') == 'US' ? 'selected' : '' }}>United States (US)</option>
                        <option value="CA" {{ old('country_code') == 'CA' ? 'selected' : '' }}>Canada (CA)</option>
                        <option value="GB" {{ old('country_code') == 'GB' ? 'selected' : '' }}>United Kingdom (GB)</option>
                        <option value="DE" {{ old('country_code') == 'DE' ? 'selected' : '' }}>Germany (DE)</option>
                        <option value="IN" {{ old('country_code') == 'IN' ? 'selected' : '' }}>India (IN)</option>
                        <option value="AU" {{ old('country_code') == 'AU' ? 'selected' : '' }}>Australia (AU)</option>
                    </select>
                    @error('country_code') 
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
                    @enderror
                </div>
            </div>

            <!-- Preferences -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                    <select id="timezone" 
                            name="timezone" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="UTC" {{ old('timezone') == 'UTC' ? 'selected' : '' }}>UTC</option>
                        <option value="America/New_York" {{ old('timezone') == 'America/New_York' ? 'selected' : '' }}>Eastern Time (ET)</option>
                        <option value="America/Chicago" {{ old('timezone') == 'America/Chicago' ? 'selected' : '' }}>Central Time (CT)</option>
                        <option value="America/Denver" {{ old('timezone') == 'America/Denver' ? 'selected' : '' }}>Mountain Time (MT)</option>
                        <option value="America/Los_Angeles" {{ old('timezone') == 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time (PT)</option>
                        <option value="Europe/London" {{ old('timezone') == 'Europe/London' ? 'selected' : '' }}>London (GMT)</option>
                        <option value="Europe/Berlin" {{ old('timezone') == 'Europe/Berlin' ? 'selected' : '' }}>Berlin (CET)</option>
                        <option value="Asia/Kolkata" {{ old('timezone') == 'Asia/Kolkata' ? 'selected' : '' }}>India (IST)</option>
                    </select>
                    @error('timezone') 
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label for="locale" class="block text-sm font-medium text-gray-700 mb-2">Language</label>
                    <select id="locale" 
                            name="locale" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="en" {{ old('locale') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="es" {{ old('locale') == 'es' ? 'selected' : '' }}>Spanish</option>
                        <option value="fr" {{ old('locale') == 'fr' ? 'selected' : '' }}>French</option>
                        <option value="de" {{ old('locale') == 'de' ? 'selected' : '' }}>German</option>
                        <option value="hi" {{ old('locale') == 'hi' ? 'selected' : '' }}>Hindi</option>
                    </select>
                    @error('locale') 
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
                    @enderror
                </div>
            </div>

            <!-- Role Assignment -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-4">Assign Roles *</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($roles as $role)
                        <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" 
                                   name="roles[]" 
                                   value="{{ $role->name }}"
                                   {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="font-medium text-gray-900">{{ $role->name }}</span>
                                @if($role->name === 'Super Admin')
                                    <span class="block text-xs text-red-600">Full system access</span>
                                @elseif($role->name === 'Admin')
                                    <span class="block text-xs text-blue-600">Administrative access</span>
                                @elseif($role->name === 'Instructor')
                                    <span class="block text-xs text-green-600">Course management</span>
                                @elseif($role->name === 'Manager')
                                    <span class="block text-xs text-purple-600">Operational management</span>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('roles') 
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Create Admin User
                </button>
            </div>
        </form>
    </div>
</x-layouts.main>
