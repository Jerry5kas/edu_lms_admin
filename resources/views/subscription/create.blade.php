<x-layouts.main>

    <div class="bg-gray-50 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white rounded-2xl shadow-md p-6 w-full max-w-lg">
        <h2 class="text-xl font-bold mb-4">Add Subscription Plan</h2>

        <form @submit.prevent="addPlan()">
            <div class="space-y-4">
                <input type="text" placeholder="Plan Name" x-model="form.name" class="w-full border rounded-lg px-3 py-2">
                <input type="number" placeholder="Price (₹)" x-model="form.price" class="w-full border rounded-lg px-3 py-2">
                <input type="number" placeholder="Duration (months)" x-model="form.duration" class="w-full border rounded-lg px-3 py-2">
                <textarea placeholder="Features" x-model="form.features" class="w-full border rounded-lg px-3 py-2"></textarea>
            </div>

            <div class="mt-6 flex justify-between">
                <a href="/subscription" class="px-4 py-2 rounded-xl bg-gray-200">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 text-white">Save</button>
            </div>
        </form>
    </div>

    </div>


</x-layouts.main>
