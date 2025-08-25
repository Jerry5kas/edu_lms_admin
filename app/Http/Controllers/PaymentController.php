<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
public function index()
{
$payments = Payment::with(['user','order'])->latest()->paginate(10);
return view('payments.index', compact('payments'));
}

public function create()
{
$orders = Order::all();
$users = User::all();
return view('payments.create', compact('orders','users'));
}

public function store(Request $request)
{
$data = $request->validate([
'order_id' => 'required|exists:orders,id',
'user_id' => 'required|exists:users,id',
'amount_cents' => 'required|integer|min:1',
'currency' => 'required|string|max:3',
'gateway' => 'required|string',
'gateway_payment_id' => 'required|unique:payments,gateway_payment_id',
'method' => 'nullable|string',
'status' => 'required|string',
]);

Payment::create($data);

return redirect()->route('payments.index')->with('success','Payment created successfully.');
}

public function edit(Payment $payment)
{
$orders = Order::all();
$users = User::all();
return view('payments.edit', compact('payment','orders','users'));
}

public function update(Request $request, Payment $payment)
{
$data = $request->validate([
'order_id' => 'required|exists:orders,id',
'user_id' => 'required|exists:users,id',
'amount_cents' => 'required|integer|min:1',
'currency' => 'required|string|max:3',
'gateway' => 'required|string',
'gateway_payment_id' => 'required|unique:payments,gateway_payment_id,'.$payment->id,
'method' => 'nullable|string',
'status' => 'required|string',
]);

$payment->update($data);

return redirect()->route('payments.index')->with('success','Payment updated successfully.');
}

public function destroy(Payment $payment)
{
$payment->delete();
return redirect()->route('payments.index')->with('success','Payment deleted successfully.');
}
}
