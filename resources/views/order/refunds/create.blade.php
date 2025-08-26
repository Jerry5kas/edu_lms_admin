<x-layouts.main>
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Create Refund</h1>
            <p class="text-gray-600 mt-2">Create a new refund for a payment</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('refunds.index') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                Back to Refunds
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Create Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Refund Information</h2>

                <form method="POST" action="{{ route('refunds.store') }}">
                    @csrf

                    <div class="space-y-6">
                        <!-- Payment Selection -->
                        <div>
                            <label for="payment_id" class="block text-sm font-medium text-gray-700 mb-2">Select Payment</label>
                            <select name="payment_id" id="payment_id" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Choose a payment...</option>
                                @foreach($payments as $payment)
                                    <option value="{{ $payment->id }}"
                                            {{ $selectedPayment && $selectedPayment->id == $payment->id ? 'selected' : '' }}
                                            data-amount="{{ $payment->amount_cents }}"
                                            data-currency="{{ $payment->currency }}"
                                            data-user="{{ $payment->user->name }}"
                                            data-order="{{ $payment->order->id }}">
                                        #{{ $payment->id }} - {{ $payment->user->name }} - ₹{{ number_format($payment->amount_cents / 100, 2) }} ({{ ucfirst($payment->status) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Details (Dynamic) -->
                        <div id="payment-details" class="hidden bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Payment Details</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Customer</p>
                                    <p class="text-lg font-semibold text-gray-900" id="customer-name">-</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Order ID</p>
                                    <p class="text-lg font-semibold text-gray-900" id="order-id">-</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Payment Amount</p>
                                    <p class="text-lg font-semibold text-gray-900" id="payment-amount">-</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Currency</p>
                                    <p class="text-lg font-semibold text-gray-900" id="payment-currency">-</p>
                                </div>
                            </div>
                        </div>

                        <!-- Refund Amount -->
                        <div>
                            <label for="amount_cents" class="block text-sm font-medium text-gray-700 mb-2">Refund Amount (in cents)</label>
                            <input type="number" name="amount_cents" id="amount_cents" required min="1"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Enter refund amount in cents">
                            @error('amount_cents')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-500 mt-1">Enter the amount in cents (e.g., 5000 for ₹50.00)</p>
                        </div>

                        <!-- Refund Reason -->
                        <div>
                            <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Refund Reason</label>
                            <textarea name="reason" id="reason" rows="4" required
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Enter the reason for this refund..."></textarea>
                            @error('reason')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('refunds.index') }}"
                               class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                Create Refund
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Information Panel -->
        <div class="space-y-6">
            <!-- Refund Guidelines -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Refund Guidelines</h2>
                <div class="space-y-3 text-sm text-gray-600">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Only captured payments can be refunded</p>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Refund amount cannot exceed remaining amount</p>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Partial refunds are supported</p>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Refunds will be processed immediately</p>
                    </div>
                </div>
            </div>

            <!-- Available Payments -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Available Payments</h2>
                <div class="space-y-3">
                    @foreach($payments->take(5) as $payment)
                    <div class="border border-gray-200 rounded-lg p-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-900">#{{ $payment->id }}</p>
                                <p class="text-xs text-gray-500">{{ $payment->user->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900">₹{{ number_format($payment->amount_cents / 100, 2) }}</p>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @if($payments->count() > 5)
                    <p class="text-sm text-gray-500 text-center">... and {{ $payments->count() - 5 }} more</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentSelect = document.getElementById('payment_id');
    const paymentDetails = document.getElementById('payment-details');
    const customerName = document.getElementById('customer-name');
    const orderId = document.getElementById('order-id');
    const paymentAmount = document.getElementById('payment-amount');
    const paymentCurrency = document.getElementById('payment-currency');
    const amountInput = document.getElementById('amount_cents');

    paymentSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        if (this.value) {
            // Show payment details
            paymentDetails.classList.remove('hidden');

            // Update details
            customerName.textContent = selectedOption.getAttribute('data-user');
            orderId.textContent = '#' + selectedOption.getAttribute('data-order');
            paymentAmount.textContent = '₹' + (parseInt(selectedOption.getAttribute('data-amount')) / 100).toFixed(2);
            paymentCurrency.textContent = selectedOption.getAttribute('data-currency');

            // Set max amount for refund
            const maxAmount = parseInt(selectedOption.getAttribute('data-amount'));
            amountInput.max = maxAmount;
            amountInput.placeholder = `Max: ${maxAmount} cents (₹${(maxAmount / 100).toFixed(2)})`;
        } else {
            // Hide payment details
            paymentDetails.classList.add('hidden');
        }
    });

    // Trigger change event if payment is pre-selected
    if (paymentSelect.value) {
        paymentSelect.dispatchEvent(new Event('change'));
    }
});
</script>
    </x-layouts.main>
