<div class="bg-blue-50 min-h-screen flex items-center justify-center p-4" x-data="{ fileName: '' }">
    <div class="bg-white rounded-xl shadow p-6 w-full max-w-6xl">
        <h2 class="text-lg font-semibold mb-6 flex items-center">
            Course Details
            <span class="ml-2 text-blue-500 cursor-pointer">?</span>
        </h2>

        <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left: Thumbnail Upload -->
            <div class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                <input type="file" id="thumbnail" class="hidden"
                       @change="fileName = $event.target.files[0]?.name">
                <label for="thumbnail" class="cursor-pointer flex flex-col items-center justify-center w-full h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16l4-4a4 4 0 015.657 0L21 20M16 8a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="text-gray-600">Drag or <span class="text-blue-600 underline">Browse</span></p>
                    <p class="text-xs text-gray-400">PNG, JPEG (max 5MB)</p>
                </label>
                <p class="mt-2 text-sm text-gray-500" x-text="fileName"></p>
            </div>

            <!-- Right: Inputs -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Thumbnail Image <span class="text-red-500">(Required)</span>
                    </label>
                    <input type="text" maxlength="100"
                           class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300"
                           placeholder="Enter thumbnail name">
                    <p class="text-xs text-gray-400 text-right">0 / 100</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Course Category</label>
                    <input type="text" placeholder="Enter course category"
                           class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Course Level</label>
                    <select class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
                        <option>Select course level</option>
                        <option>Beginner</option>
                        <option>Intermediate</option>
                        <option>Advanced</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Course Time</label>
                    <input type="text" placeholder="Enter course time"
                           class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Lesson</label>
                    <input type="text" placeholder="Enter total lessons"
                           class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
                </div>
            </div>
        </form>

        <div class="flex justify-end space-x-4 mt-6">
            <button type="button" class="px-4 py-2 rounded-lg border border-blue-400 text-blue-600 hover:bg-blue-50">
                Cancel
            </button>
            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                Continue
            </button>
        </div>
    </div>
</div>
