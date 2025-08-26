<x-layouts.main>
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Payment</h1>
            <p class="text-gray-600 mt-2">Payment #{{ $payment->id }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('payments.show', $payment) }}"
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                Back to Payment
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Edit Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Payment Information</h2>

                <form method="POST" action="{{ route('payments.update', $payment) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Payment Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                            <select name="status" id="status"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach(['created', 'authorized', 'captured', 'failed', 'refunded'] as $status)
                                    <option value="{{ $status }}" {{ $payment->status === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount_cents" class="block text-sm font-medium text-gray-700 mb-2">Amount (in cents)</label>
                            <input type="number" name="amount_cents" id="amount_cents" value="{{ $payment->amount_cents }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('amount_cents')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Currency -->
                        <div>
                            <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                            <input type="text" name="currency" id="currency" value="{{ $payment->currency }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('currency')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Method -->
                        <div>
                            <label for="method" class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                            <input type="text" name="method" id="method" value="{{ $payment->method }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('method')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Error Information -->
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Error Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="error_code" class="block text-sm font-medium text-gray-700 mb-2">Error Code</label>
                                <input type="text" name="error_code" id="error_code" value="{{ $payment->error_code }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('error_code')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="error_description" class="block text-sm font-medium text-gray-700 mb-2">Error Description</label>
                                <input type="text" name="error_description" id="error_description" value="{{ $payment->error_description }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('error_description')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3 mt-6">
                        <a href="{{ route('payments.show', $payment) }}"
                           class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">
                            Cancel
                        </a>
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            Update Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="space-y-6">
            <!-- Current Payment Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Current Payment Info</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Payment ID</p>
                        <p class="text-lg font-semibold text-gray-900">#{{ $payment->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Gateway Payment ID</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $payment->gateway_payment_id }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Customer</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $payment->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $payment->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Current Status</p>
                        <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full
                            {{ $payment->status === 'captured' ? 'bg-green-100 text-green-800' :
                               ($payment->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Payment Details</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Amount:</span>
                        <span class="font-semibold">₹{{ number_format($payment->amount_cents / 100, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Currency:</span>
                        <span class="font-semibold">{{ $payment->currency }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Gateway:</span>
                        <span class="font-semibold">{{ ucfirst($payment->gateway) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Method:</span>
                        <span class="font-semibold">{{ ucfirst($payment->method ?? 'N/A') }}</span>
                    </div>
                </div>
            </div>

            <!-- Order Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Information</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Order ID</p>
                        <p class="text-lg font-semibold text-gray-900">#{{ $payment->order->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Order Status</p>
                        <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full {{ $payment->order->status_badge_class }}">
                            {{ ucfirst($payment->order->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Order Total</p>
                        <p class="text-lg font-semibold text-gray-900">₹{{ number_format($payment->order->total_cents / 100, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            @if($payment->status === 'failed')
            <div class="bg-white rounded-lg shadow p-6 border border-red-200">
                <h2 class="text-xl font-semibold text-red-900 mb-4">Danger Zone</h2>
                <form method="POST" action="{{ route('payments.destroy', $payment) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700"
                            onclick="return confirm('Are you sure you want to delete this payment? This action cannot be undone.')">
                        Delete Payment
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
</x-layouts.main>
