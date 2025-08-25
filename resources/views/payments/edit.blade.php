<x-layouts.main>
    <div class="p-6 max-w-2xl mx-auto">
        <h1 class="text-xl font-bold mb-4">Edit Payment</h1>

        <form action="{{ route('payments.update',$payment) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <!-- Similar fields but prefilled -->
            <div>
                <label class="block">Amount (cents)</label>
                <input type="number" name="amount_cents" value="{{ $payment->amount_cents }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    @foreach(['created','authorized','captured','failed','refunded'] as $s)
                        <option value="{{ $s }}" {{ $payment->status==$s?'selected':'' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
        </form>
    </div>

    </x-layouts.main>
