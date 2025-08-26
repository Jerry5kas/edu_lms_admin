<x-layouts.main>
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Order</h1>
            <p class="text-gray-600 mt-2">Order #{{ $order->id }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('orders.show', $order) }}"
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                Back to Order
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Edit Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Information</h2>

                <form method="POST" action="{{ route('orders.update', $order) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Order Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Order Status</label>
                            <select name="status" id="status"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach(['pending', 'paid', 'failed', 'cancelled', 'refunded'] as $status)
                                    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Currency -->
                        <div>
                            <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                            <input type="text" name="currency" id="currency" value="{{ $order->currency }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('currency')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount_cents" class="block text-sm font-medium text-gray-700 mb-2">Amount (in cents)</label>
                            <input type="number" name="amount_cents" id="amount_cents" value="{{ $order->amount_cents }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('amount_cents')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Discount -->
                        <div>
                            <label for="discount_cents" class="block text-sm font-medium text-gray-700 mb-2">Discount (in cents)</label>
                            <input type="number" name="discount_cents" id="discount_cents" value="{{ $order->discount_cents }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('discount_cents')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tax -->
                        <div>
                            <label for="tax_cents" class="block text-sm font-medium text-gray-700 mb-2">Tax (in cents)</label>
                            <input type="number" name="tax_cents" id="tax_cents" value="{{ $order->tax_cents }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('tax_cents')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total -->
                        <div>
                            <label for="total_cents" class="block text-sm font-medium text-gray-700 mb-2">Total (in cents)</label>
                            <input type="number" name="total_cents" id="total_cents" value="{{ $order->total_cents }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('total_cents')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Admin Notes -->
                    <div class="mt-6">
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                        <textarea name="admin_notes" id="admin_notes" rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Add any admin notes here...">{{ $order->notes['admin_notes'] ?? '' }}</textarea>
                        @error('admin_notes')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3 mt-6">
                        <a href="{{ route('orders.show', $order) }}"
                           class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">
                            Cancel
                        </a>
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            Update Order
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="space-y-6">
            <!-- Current Order Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Current Order Info</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Order ID</p>
                        <p class="text-lg font-semibold text-gray-900">#{{ $order->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Gateway Order ID</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $order->gateway_order_id }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Customer</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $order->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Current Status</p>
                        <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full {{ $order->status_badge_class }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Order Totals -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Totals</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-semibold">₹{{ number_format($order->amount_cents / 100, 2) }}</span>
                    </div>
                    @if($order->discount_cents > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Discount:</span>
                        <span class="font-semibold text-green-600">-₹{{ number_format($order->discount_cents / 100, 2) }}</span>
                    </div>
                    @endif
                    @if($order->tax_cents > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tax:</span>
                        <span class="font-semibold">₹{{ number_format($order->tax_cents / 100, 2) }}</span>
                    </div>
                    @endif
                    <div class="border-t pt-3">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-gray-900">Total:</span>
                            <span class="text-lg font-bold text-gray-900">₹{{ number_format($order->total_cents / 100, 2) }}</span>
                        </div>
                        <p class="text-sm text-gray-500">{{ $order->currency }}</p>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            @if($order->status === 'pending')
            <div class="bg-white rounded-lg shadow p-6 border border-red-200">
                <h2 class="text-xl font-semibold text-red-900 mb-4">Danger Zone</h2>
                <form method="POST" action="{{ route('orders.cancel', $order) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700"
                            onclick="return confirm('Are you sure you want to cancel this order? This action cannot be undone.')">
                        Cancel Order
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
</x-layouts.main>
