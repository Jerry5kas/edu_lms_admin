<x-layouts.main>
    <div class="bg-gray-50 min-h-screen p-6">
        <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-md p-6" x-data="{ openMenu: false }">

            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Subscription Plans</h1>
                <a href="{{ route('subscriptions.create') }}"
                   class="mt-4 md:mt-0 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl">
                    + Add Plan
                </a>
            </div>

            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-100 text-left text-sm text-gray-600">
                    <tr>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Duration</th>
                        <th class="px-4 py-2">Features</th>
                        <th class="px-4 py-2 text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700 divide-y">
                    @foreach($subscriptions as $plan)
                        <tr>
                            <td class="px-4 py-3 font-semibold">{{ $plan->name }}</td>
                            <td class="px-4 py-3">₹{{ $plan->price }}</td>
                            <td class="px-4 py-3">{{ $plan->duration }} month(s)</td>
                            <td class="px-4 py-3">{{ $plan->features }}</td>
                            <td class="px-4 py-3 text-right space-x-3">
                                <a href="{{ route('subscriptions.edit', $plan->id) }}"
                                   class="text-blue-600 hover:underline">Edit</a>

                                <form action="{{ route('subscriptions.destroy', $plan->id) }}"
                                      method="POST" class="inline-block"
                                      onsubmit="return confirm('Are you sure you want to delete this plan?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="grid md:hidden gap-4">
                @foreach($subscriptions as $plan)
                    <div class="border rounded-xl p-4 shadow-sm bg-gray-50">
                        <h2 class="text-lg font-bold text-gray-800">{{ $plan->name }}</h2>
                        <p class="text-gray-600">₹{{ $plan->price }} / {{ $plan->duration }} month(s)</p>
                        <p class="mt-2 text-sm text-gray-700">{{ $plan->features }}</p>

                        <!-- Actions -->
                        <div class="flex justify-end mt-4 space-x-4">
                            <a href="{{ route('subscriptions.edit', $plan->id) }}"
                               class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('subscriptions.destroy', $plan->id) }}"
                                  method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-layouts.main>
