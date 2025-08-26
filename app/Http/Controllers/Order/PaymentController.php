<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments (admin)
     */
    public function index(Request $request)
    {
        $query = Payment::with(['order.user', 'user'])
            ->latest();

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by gateway
        if ($request->has('gateway') && $request->gateway !== '') {
            $query->where('gateway', $request->gateway);
        }

        // Filter by user
        if ($request->has('user_id') && $request->user_id !== '') {
            $query->where('user_id', $request->user_id);
        }

        // Search by gateway payment ID
        if ($request->has('search') && $request->search !== '') {
            $query->where('gateway_payment_id', 'like', '%' . $request->search . '%');
        }

        $payments = $query->paginate(15);
        $users = User::select('id', 'name', 'email')->get();
        $statuses = ['created', 'authorized', 'captured', 'failed', 'refunded'];
        $gateways = ['razorpay'];

        // Stats
        $stats = [
            'total_payments' => Payment::count(),
            'total_amount' => Payment::where('status', 'captured')->sum('amount_cents') / 100,
            'successful_payments' => Payment::where('status', 'captured')->count(),
            'failed_payments' => Payment::where('status', 'failed')->count(),
        ];

        return view('order.payments.index', compact('payments', 'users', 'statuses', 'gateways', 'stats'));
    }

    /**
     * Display the specified payment
     */
    public function show(Payment $payment)
    {
        $payment->load(['order.user', 'user', 'refunds']);
        
        return view('order.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified payment
     */
    public function edit(Payment $payment)
    {
        $payment->load(['order.user', 'user']);
        
        return view('order.payments.edit', compact('payment'));
    }

    /**
     * Update the specified payment
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:created,authorized,captured,failed,refunded',
            'error_code' => 'nullable|string',
            'error_description' => 'nullable|string',
        ]);

        $oldStatus = $payment->status;
        $newStatus = $request->status;

        // Update status timestamps
        $updateData = [
            'status' => $newStatus,
            'error_code' => $request->error_code,
            'error_description' => $request->error_description,
        ];

        // Set appropriate timestamp based on status change
        if ($oldStatus !== $newStatus) {
            switch ($newStatus) {
                case 'captured':
                    $updateData['captured_at'] = now();
                    break;
                case 'refunded':
                    $updateData['refunded_at'] = now();
                    break;
            }
        }

        $payment->update($updateData);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment updated successfully!');
    }

    /**
     * Remove the specified payment
     */
    public function destroy(Payment $payment)
    {
        // Only allow deletion of failed payments
        if ($payment->status !== 'failed') {
            return back()->withErrors(['error' => 'Only failed payments can be deleted.']);
        }

        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully!');
    }


}
