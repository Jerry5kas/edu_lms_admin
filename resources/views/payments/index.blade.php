<x-layouts.main>
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Payments</h1>
            <a href="{{ route('payments.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg">+ Add Payment</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">User</th>
                    <th class="px-4 py-2">Order</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $payment->id }}</td>
                        <td class="px-4 py-2">{{ $payment->user->name }}</td>
                        <td class="px-4 py-2">#{{ $payment->order_id }}</td>
                        <td class="px-4 py-2">{{ $payment->amount_cents/100 }} {{ $payment->currency }}</td>
                        <td class="px-4 py-2">
                                <span class="px-2 py-1 text-xs rounded
                                    @if($payment->status=='captured') bg-green-100 text-green-600
                                    @elseif($payment->status=='failed') bg-red-100 text-red-600
                                    @else bg-yellow-100 text-yellow-600 @endif">
                                    {{ ucfirst($payment->status) }}
                                </span>
                        </td>
                        <td class="px-4 py-2 flex space-x-2">
                            <a href="{{ route('payments.edit',$payment) }}"
                               class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('payments.destroy',$payment) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $payments->links() }}</div>
    </div>

</x-layouts.main>
