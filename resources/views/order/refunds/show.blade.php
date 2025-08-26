<x-layouts.main>
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Refund Details</h1>
            <p class="text-gray-600 mt-2">Refund #{{ $refund->id }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('refunds.index') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                Back to Refunds
            </a>
            <a href="{{ route('refunds.edit', $refund) }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Edit Refund
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Refund Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Refund Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Refund Summary</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Refund ID</p>
                        <p class="text-lg font-semibold text-gray-900">#{{ $refund->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Gateway Refund ID</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $refund->gateway_refund_id }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Status</p>
                        <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full
                            {{ $refund->status === 'processed' ? 'bg-green-100 text-green-800' :
                               ($refund->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($refund->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Created Date</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $refund->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    @if($refund->processed_at)
                    <div>
                        <p class="text-sm font-medium text-gray-600">Processed Date</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $refund->processed_at->format('M d, Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Payment Information</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Payment ID</p>
                        <p class="text-lg font-semibold text-gray-900">#{{ $refund->payment->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Gateway Payment ID</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $refund->payment->gateway_payment_id }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Payment Status</p>
                        <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full
                            {{ $refund->payment->status === 'captured' ? 'bg-green-100 text-green-800' :
                               ($refund->payment->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($refund->payment->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Payment Amount</p>
                        <p class="text-lg font-semibold text-gray-900">₹{{ number_format($refund->payment->amount_cents / 100, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Information</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Order ID</p>
                        <p class="text-lg font-semibold text-gray-900">#{{ $refund->payment->order->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Order Status</p>
                        <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full {{ $refund->payment->order->status_badge_class }}">
                            {{ ucfirst($refund->payment->order->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Order Total</p>
                        <p class="text-lg font-semibold text-gray-900">₹{{ number_format($refund->payment->order->total_cents / 100, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Order Date</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $refund->payment->order->placed_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Refund Reason -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Refund Reason</h2>
                <p class="text-gray-700">{{ $refund->reason }}</p>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Customer Information</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Name</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $refund->payment->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Email</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $refund->payment->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Phone</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $refund->payment->user->phone ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Refund Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Refund Details</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Refund Amount:</span>
                        <span class="font-semibold">₹{{ number_format($refund->amount_cents / 100, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Payment Amount:</span>
                        <span class="font-semibold">₹{{ number_format($refund->payment->amount_cents / 100, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Currency:</span>
                        <span class="font-semibold">{{ $refund->payment->currency }}</span>
                    </div>
                    <div class="border-t pt-3">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-gray-900">Remaining:</span>
                            <span class="text-lg font-bold text-gray-900">₹{{ number_format(($refund->payment->amount_cents - $refund->amount_cents) / 100, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Actions</h2>
                <div class="space-y-3">
                    @if($refund->status === 'pending')
                        <form method="POST" action="{{ route('refunds.process', $refund) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700"
                                    onclick="return confirm('Are you sure you want to process this refund?')">
                                Process Refund
                            </button>
                        </form>
                    @endif

                    @if($refund->status === 'pending')
                        <form method="POST" action="{{ route('refunds.destroy', $refund) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700"
                                    onclick="return confirm('Are you sure you want to delete this refund?')">
                                Delete Refund
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.main>
