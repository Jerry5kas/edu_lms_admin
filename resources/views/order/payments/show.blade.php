<x-layouts.main>
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Payment Details</h1>
            <p class="text-gray-600 mt-2">Payment #{{ $payment->id }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('payments.index') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                Back to Payments
            </a>
            <a href="{{ route('payments.edit', $payment) }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Edit Payment
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Payment Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Payment Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Payment Summary</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Payment ID</p>
                        <p class="text-lg font-semibold text-gray-900">#{{ $payment->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Gateway Payment ID</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $payment->gateway_payment_id }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Status</p>
                        <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full
                            {{ $payment->status === 'captured' ? 'bg-green-100 text-green-800' :
                               ($payment->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Method</p>
                        <p class="text-lg font-semibold text-gray-900">{{ ucfirst($payment->method ?? 'N/A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Created Date</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $payment->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    @if($payment->captured_at)
                    <div>
                        <p class="text-sm font-medium text-gray-600">Captured Date</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $payment->captured_at->format('M d, Y H:i') }}</p>
                    </div>
                    @endif
                    @if($payment->refunded_at)
                    <div>
                        <p class="text-sm font-medium text-gray-600">Refunded Date</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $payment->refunded_at->format('M d, Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Information</h2>
                <div class="grid grid-cols-2 gap-4">
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
                    <div>
                        <p class="text-sm font-medium text-gray-600">Order Date</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $payment->order->placed_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Error Information -->
            @if($payment->error_code || $payment->error_description)
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
                <h2 class="text-xl font-semibold text-red-900 mb-4">Error Information</h2>
                <div class="space-y-3">
                    @if($payment->error_code)
                    <div>
                        <p class="text-sm font-medium text-gray-600">Error Code</p>
                        <p class="text-lg font-semibold text-red-900">{{ $payment->error_code }}</p>
                    </div>
                    @endif
                    @if($payment->error_description)
                    <div>
                        <p class="text-sm font-medium text-gray-600">Error Description</p>
                        <p class="text-lg font-semibold text-red-900">{{ $payment->error_description }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Refunds -->
            @if($payment->refunds->count() > 0)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Refunds</h2>
                <div class="space-y-4">
                    @foreach($payment->refunds as $refund)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Refund #{{ $refund->id }}</p>
                                <p class="text-sm text-gray-500">{{ $refund->gateway_refund_id }}</p>
                                <p class="text-sm text-gray-500">{{ $refund->reason }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-semibold text-gray-900">₹{{ number_format($refund->amount_cents / 100, 2) }}</p>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $refund->status === 'processed' ? 'bg-green-100 text-green-800' :
                                       ($refund->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($refund->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Customer Information</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Name</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $payment->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Email</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $payment->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Phone</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $payment->user->phone ?? 'N/A' }}</p>
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

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Actions</h2>
                <div class="space-y-3">
                    @if($payment->status === 'captured')
                        <a href="{{ route('refunds.create', ['payment_id' => $payment->id]) }}"
                           class="block w-full bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 text-center">
                            Create Refund
                        </a>
                    @endif

                    @if($payment->status === 'failed')
                        <form method="POST" action="{{ route('payments.destroy', $payment) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700"
                                    onclick="return confirm('Are you sure you want to delete this payment?')">
                                Delete Payment
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.main>
