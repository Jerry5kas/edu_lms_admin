<x-layouts.main>
    <div class="p-6 max-w-2xl mx-auto">
        <h1 class="text-xl font-bold mb-4">Add Payment</h1>

        <form action="{{ route('payments.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block">Order</label>
                <select name="order_id" class="w-full border rounded px-3 py-2">
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}">Order #{{ $order->id }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block">User</label>
                <select name="user_id" class="w-full border rounded px-3 py-2">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block">Amount (cents)</label>
                <input type="number" name="amount_cents" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block">Currency</label>
                <input type="text" name="currency" value="EUR" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block">Gateway Payment ID</label>
                <input type="text" name="gateway_payment_id" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="created">Created</option>
                    <option value="authorized">Authorized</option>
                    <option value="captured">Captured</option>
                    <option value="failed">Failed</option>
                    <option value="refunded">Refunded</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
        </form>
    </div>
</x-layouts.main>
