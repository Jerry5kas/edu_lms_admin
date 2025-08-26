<div class="w-full max-w-7xl bg-white rounded-xl shadow-md p-6" x-data="{ open:false, selected:'Popular' }">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
        <!-- Breadcrumb -->
        <div class="text-gray-500 text-sm">
            Home / <span class="text-gray-900 font-medium">Category</span>
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
                        <li><a href="#" @click="selected='Popular'; open=false" class="block px-4 py-2 hover:bg-gray-100">Popular</a></li>
                        <li><a href="#" @click="selected='Latest'; open=false" class="block px-4 py-2 hover:bg-gray-100">Latest</a></li>
                        <li><a href="#" @click="selected='Trending'; open=false" class="block px-4 py-2 hover:bg-gray-100">Trending</a></li>
                        <li><a href="#" @click="selected='Matches'; open=false" class="block px-4 py-2 hover:bg-gray-100">Matches</a></li>
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
                <th class="p-3"><input type="checkbox"></th>
                <th class="p-3">Students</th>
                <th class="p-3">Email ID</th>
                <th class="p-3">Courses</th>
                <th class="p-3">Certificates Earned</th>
                <th class="p-3">Status</th>
                <th class="p-3">Actions</th>
            </tr>
            </thead>
            <tbody>
            <!-- Row -->
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3"><input type="checkbox"></td>
                <td class="p-3 flex items-center gap-2">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-8 h-8 rounded-full" alt="">
                    Jane Cooper
                </td>
                <td class="p-3">example@mail.com</td>
                <td class="p-3">12</td>
                <td class="p-3">10</td>
                <td class="p-3"><span class="px-2 py-1 text-xs rounded-lg bg-orange-100 text-orange-600">In Progress</span></td>
                <td class="p-3"><a href="#" class="text-blue-500 hover:underline">View More</a></td>
            </tr>

            <!-- Another Row -->
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3"><input type="checkbox"></td>
                <td class="p-3 flex items-center gap-2">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-8 h-8 rounded-full" alt="">
                    Guy Hawkins
                </td>
                <td class="p-3">example@mail.com</td>
                <td class="p-3">18</td>
                <td class="p-3">12</td>
                <td class="p-3"><span class="px-2 py-1 text-xs rounded-lg bg-green-100 text-green-600">Completed</span></td>
                <td class="p-3"><a href="#" class="text-blue-500 hover:underline">View More</a></td>
            </tr>
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
</div>
