<x-layouts.main>
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Order Details</h1>
            <p class="text-gray-600 mt-2">Order #{{ $order->id }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('orders.index') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                Back to Orders
            </a>
            <a href="{{ route('orders.edit', $order) }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Edit Order
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Order ID</p>
                        <p class="text-lg font-semibold text-gray-900">#{{ $order->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Gateway Order ID</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $order->gateway_order_id }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Status</p>
                        <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full {{ $order->status_badge_class }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Placed Date</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $order->placed_at ? $order->placed_at->format('M d, Y H:i') : 'N/A' }}
                        </p>
                    </div>
                    @if($order->paid_at)
                    <div>
                        <p class="text-sm font-medium text-gray-600">Paid Date</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $order->paid_at->format('M d, Y H:i') }}</p>
                    </div>
                    @endif
                    @if($order->cancelled_at)
                    <div>
                        <p class="text-sm font-medium text-gray-600">Cancelled Date</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $order->cancelled_at->format('M d, Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Items</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $item->course->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->course->description }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₹{{ number_format($item->unit_price_cents / 100, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">₹{{ number_format($item->line_total_cents / 100, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Payments -->
            @if($order->payments->count() > 0)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Payments</h2>
                <div class="space-y-4">
                    @foreach($order->payments as $payment)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Payment #{{ $payment->id }}</p>
                                <p class="text-sm text-gray-500">{{ $payment->gateway_payment_id }}</p>
                                <p class="text-sm text-gray-500">{{ $payment->method }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-semibold text-gray-900">₹{{ number_format($payment->amount_cents / 100, 2) }}</p>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $payment->status === 'captured' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($payment->status) }}
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
                        <p class="text-lg font-semibold text-gray-900">{{ $order->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Email</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $order->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Phone</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $order->user->phone ?? 'N/A' }}</p>
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

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Actions</h2>
                <div class="space-y-3">
                    @if($order->status === 'pending')
                        <form method="POST" action="{{ route('orders.cancel', $order) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700"
                                    onclick="return confirm('Are you sure you want to cancel this order?')">
                                Cancel Order
                            </button>
                        </form>
                    @endif

                    @if($order->status === 'paid' && !$order->invoice)
                        <a href="{{ route('invoices.create', ['order_id' => $order->id]) }}"
                           class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-center">
                            Generate Invoice
                        </a>
                    @endif

                    @if($order->invoice)
                        <a href="{{ route('invoices.show', $order->invoice) }}"
                           class="block w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-center">
                            View Invoice
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.main>
