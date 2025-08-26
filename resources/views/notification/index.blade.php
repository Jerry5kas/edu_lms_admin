<x-layouts.main>
    <div class="bg-gray-50 p-4">

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Notifications List</h1>
            <p class="text-gray-500 text-sm">View and manage all the notifications</p>
        </div>
        <a href="/notifications/create" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-full shadow flex items-center gap-2">
            <!-- Heroicon: plus -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create Notification
        </a>
    </div>

    <!-- Controls -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
        <div class="flex items-center space-x-2">
            <label class="text-gray-600 text-sm">Show</label>
            <select class="border rounded px-2 py-1 text-sm">
                <option>10</option>
                <option>25</option>
                <option>50</option>
            </select>
            <span class="text-gray-600 text-sm">entries</span>
        </div>

        <!-- Search -->
        <div class="relative">
            <input type="text" placeholder="Search..." x-model="search"
                   class="border rounded-full pl-9 pr-3 py-2 text-sm focus:ring-2 focus:ring-orange-400 w-full md:w-64">
            <!-- Heroicon: search -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M9.5 17A7.5 7.5 0 109.5 2a7.5 7.5 0 000 15z"/>
            </svg>
        </div>
    </div>

    <!-- Table (Desktop) -->
    <div class="hidden md:block bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
            <tr>
                <th class="p-3"><input type="checkbox" class="rounded border-gray-300"></th>
                <th class="p-3">Subject</th>
                <th class="p-3">Type</th>
                <th class="p-3">Channel</th>
                <th class="p-3">Scheduled</th>
                <th class="p-3">Status</th>
                <th class="p-3 text-right">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            <tr class="hover:bg-gray-50">
                <td class="p-3"><input type="checkbox" class="rounded border-gray-300"></td>
                <td class="p-3 font-medium text-gray-800">Lunch ki delay aina parvaledu...</td>
                <td class="p-3 text-gray-600">marketing</td>
                <td class="p-3 text-gray-600">email</td>
                <td class="p-3 text-gray-600">—</td>
                <td class="p-3">
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded">Pending</span>
                </td>
                <td class="p-3 flex justify-end gap-2">
                    <!-- Heroicon: eye -->
                    <button class="text-blue-500 hover:text-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                    <!-- Heroicon: pencil -->
                    <button class="text-green-500 hover:text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>
                    <!-- Heroicon: trash -->
                    <button class="text-red-500 hover:text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3H5m14 0H5"/>
                        </svg>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <!-- Card List (Mobile) -->
    <div class="md:hidden space-y-3">
        <div class="bg-white shadow rounded-lg p-4">
            <div class="flex justify-between items-center">
                <h2 class="font-medium text-gray-800">Lunch ki delay aina parvaledu...</h2>
                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded">Pending</span>
            </div>
            <p class="text-sm text-gray-600 mt-2">Type: Marketing | Channel: Email</p>
            <div class="flex justify-end gap-3 mt-3">
                <!-- Actions -->
                <div class="flex flex-col md:flex-row items-start md:items-center gap-3 md:gap-5">

                    <!-- View -->
                    <a href="#"
                       class="text-blue-500 hover:text-blue-700 flex items-center">
                        <!-- Heroicon: eye -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542
                     7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span class="ml-1 md:hidden text-sm">View</span>
                    </a>

                    <!-- Edit -->
                    <a href="/notifications/edit"
                       class="text-green-500 hover:text-green-700 flex items-center">
                        <!-- Heroicon: pencil -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002
                     2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121
                     0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        <span class="ml-1 md:hidden text-sm">Edit</span>
                    </a>

                    <!-- Delete -->
                    <form action="#"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this notification?')"
                          class="flex items-center">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 flex items-center">
                            <!-- Heroicon: trash -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2
                         2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1
                         1 0 00-1-1h-4a1 1 0 00-1 1v3H5m14 0H5"/>
                            </svg>
                            <span class="ml-1 md:hidden text-sm">Delete</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    </div>


</x-layouts.main>
