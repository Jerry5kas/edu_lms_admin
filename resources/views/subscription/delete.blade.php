<x-layouts.main>
    <div class="bg-gray-50 min-h-screen flex items-center justify-center p-6">
        <div class="bg-white rounded-2xl shadow-md p-6 w-full max-w-md text-center">
        <h2 class="text-xl font-bold mb-4 text-red-600">Delete Plan</h2>
        <p class="mb-6">Are you sure you want to delete the plan <span class="font-bold" x-text="form.name"></span>?</p>

        <div class="flex justify-between">
            <a href="#" class="px-4 py-2 rounded-xl bg-gray-200">Cancel</a>
            <button @click="deletePlan()" class="px-4 py-2 rounded-xl bg-red-600 text-white">Delete</button>
        </div>
    </div>
    </div>
</x-layouts.main>
