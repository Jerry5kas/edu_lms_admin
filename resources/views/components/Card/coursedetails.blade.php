
<div class="bg-gray-50 min-h-screen flex justify-center p-4">

<div class="max-w-2xl w-full bg-white rounded-2xl shadow p-6" x-data="{ editing: false }">

    <!-- Top Image -->
    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=400&fit=crop"
         alt="Course Image"
         class="w-full h-56 object-cover rounded-lg mb-4">

    <!-- Tag -->
    <span class="inline-block px-3 py-1 text-sm rounded-full bg-green-100 text-green-600 font-medium mb-3">
            Development
        </span>

    <!-- Title -->
    <h2 class="text-2xl font-bold text-gray-800 mb-3">
        Full Stack Web Development
    </h2>

    <!-- Creator -->
    <div class="flex items-center gap-2 mb-4">
        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Creator"
             class="w-10 h-10 rounded-full">
        <p class="text-sm text-gray-600">
            Created by <span class="font-semibold text-gray-800">Albert James</span>
        </p>
    </div>

    <!-- Lessons & Hours -->
    <div class="flex items-center justify-between text-sm text-gray-600 border-y py-3 mb-4">
        <div class="flex items-center gap-1">
            <!-- Video Camera Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M4 6h8a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z" />
            </svg>
            24 Lessons
        </div>
        <div class="flex items-center gap-1">
            <!-- Clock Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            40 Hours
        </div>
    </div>

    <!-- Rating -->
    <div class="flex items-center text-gray-700 mb-6">
        <!-- Star Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.356 4.177a1 1 0 00.95.69h4.393c.969 0 1.371 1.24.588 1.81l-3.562 2.585a1 1 0 00-.364 1.118l1.357 4.177c.3.921-.755 1.688-1.54 1.118l-3.562-2.585a1 1 0 00-1.175 0l-3.562 2.585c-.785.57-1.84-.197-1.54-1.118l1.357-4.177a1 1 0 00-.364-1.118L2.11 9.604c-.783-.57-.38-1.81.588-1.81h4.393a1 1 0 00.95-.69l1.008-3.177z" />
        </svg>
        <span class="ml-2 font-medium">4.9</span>
        <span class="ml-2 text-gray-500">(12k reviews)</span>
    </div>

    <!-- Buttons -->
    <div class="flex gap-4">
        <button @click="editing = true"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
            Edit
        </button>
        <button @click="alert('Course Updated!')"
                class="px-4 py-2 text-sm font-medium text-green-600 border border-green-600 rounded-lg hover:bg-green-50 transition">
            Update
        </button>
    </div>

    <!-- Edit Mode Example -->
    <div x-show="editing" class="mt-6 p-4 border rounded-lg bg-gray-50">
        <h3 class="text-lg font-semibold mb-2">Edit Course</h3>
        <input type="text" value="Full Stack Web Development"
               class="w-full px-3 py-2 border rounded-lg mb-2 focus:outline-none focus:ring focus:ring-blue-200">
        <textarea class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200"
                  rows="4">Course description goes here...</textarea>
        <button @click="editing = false"
                class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save</button>
    </div>
</div>

</div>

