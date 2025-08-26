<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RefundController extends Controller
{
    /**
     * Display a listing of refunds (admin)
     */
    public function index(Request $request)
    {
        $query = Refund::with(['payment.order', 'payment.user'])
            ->latest();

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by payment
        if ($request->has('payment_id') && $request->payment_id !== '') {
            $query->where('payment_id', $request->payment_id);
        }

        // Search by gateway refund ID
        if ($request->has('search') && $request->search !== '') {
            $query->where('gateway_refund_id', 'like', '%' . $request->search . '%');
        }

        $refunds = $query->paginate(15);
        $payments = Payment::where('status', 'captured')->get();
        $statuses = ['pending', 'processed', 'failed'];

        // Stats
        $stats = [
            'total_refunds' => Refund::count(),
            'total_refunded_amount' => Refund::where('status', 'processed')->sum('amount_cents') / 100,
            'pending_refunds' => Refund::where('status', 'pending')->count(),
            'failed_refunds' => Refund::where('status', 'failed')->count(),
        ];

        return view('order.refunds.index', compact('refunds', 'payments', 'statuses', 'stats'));
    }

    /**
     * Show the form for creating a new refund (Admin-initiated)
     */
    public function create(Request $request)
    {
        $paymentId = $request->get('payment_id');
        $payments = Payment::where('status', 'captured')
            ->whereDoesntHave('refunds', function($query) {
                $query->where('status', 'processed');
            })
            ->with(['order', 'user'])
            ->get();

        $selectedPayment = $paymentId ? Payment::find($paymentId) : null;

        return view('order.refunds.create', compact('payments', 'selectedPayment'));
    }

    /**
     * Store a newly created refund (Admin-initiated)
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'amount_cents' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
        ]);

        $payment = Payment::findOrFail($request->payment_id);

        // Check if payment is eligible for refund
        if ($payment->status !== 'captured') {
            return back()->withErrors(['error' => 'Payment must be captured to be eligible for refund.']);
        }

        // Check if refund amount is valid
        $totalRefunded = $payment->refunds()->where('status', 'processed')->sum('amount_cents');
        $remainingAmount = $payment->amount_cents - $totalRefunded;

        if ($request->amount_cents > $remainingAmount) {
            return back()->withErrors(['error' => 'Refund amount cannot exceed remaining amount.']);
        }

        try {
            DB::beginTransaction();

            // Create refund record
            $refund = Refund::create([
                'payment_id' => $request->payment_id,
                'amount_cents' => $request->amount_cents,
                'reason' => $request->reason,
                'gateway_refund_id' => 'REF_' . time() . '_' . rand(1000, 9999),
                'status' => 'pending',
            ]);

            // Update payment status if full refund
            if ($request->amount_cents === $remainingAmount) {
                $payment->update([
                    'status' => 'refunded',
                    'refunded_at' => now(),
                ]);

                // Update order status
                $payment->order->update([
                    'status' => 'refunded',
                    'refunded_at' => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('refunds.index')
                ->with('success', 'Refund created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Refund creation failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to create refund: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified refund
     */
    public function show(Refund $refund)
    {
        $refund->load(['payment.order', 'payment.user']);
        
        return view('order.refunds.show', compact('refund'));
    }

    /**
     * Show the form for editing the specified refund
     */
    public function edit(Refund $refund)
    {
        $payments = Payment::where('status', 'captured')->get();
        
        return view('order.refunds.edit', compact('refund', 'payments'));
    }

    /**
     * Update the specified refund
     */
    public function update(Request $request, Refund $refund)
    {
        $request->validate([
            'status' => 'required|in:pending,processed,failed',
            'reason' => 'nullable|string|max:255',
        ]);

        $oldStatus = $refund->status;
        $newStatus = $request->status;

        // Only allow status updates for pending refunds
        if ($oldStatus !== 'pending' && $oldStatus !== $newStatus) {
            return back()->withErrors(['error' => 'Only pending refunds can be updated.']);
        }

        $refund->update([
            'status' => $newStatus,
            'reason' => $request->reason ?: $refund->reason,
        ]);

        return redirect()->route('refunds.show', $refund)
            ->with('success', 'Refund updated successfully!');
    }

    /**
     * Remove the specified refund
     */
    public function destroy(Refund $refund)
    {
        // Only allow deletion of pending refunds
        if ($refund->status !== 'pending') {
            return back()->withErrors(['error' => 'Only pending refunds can be deleted.']);
        }

        $refund->delete();

        return redirect()->route('refunds.index')
            ->with('success', 'Refund deleted successfully!');
    }

    /**
     * Process refund (simulate gateway processing)
     */
    public function process(Refund $refund)
    {
        if ($refund->status !== 'pending') {
            return back()->withErrors(['error' => 'Only pending refunds can be processed.']);
        }

        try {
            DB::beginTransaction();

            // Simulate gateway processing
            $refund->update([
                'status' => 'processed',
            ]);

            // Update payment status if this was a full refund
            $payment = $refund->payment;
            $totalRefunded = $payment->refunds()->where('status', 'processed')->sum('amount_cents');
            
            if ($totalRefunded >= $payment->amount_cents) {
                $payment->update([
                    'status' => 'refunded',
                    'refunded_at' => now(),
                ]);

                // Update order status
                $payment->order->update([
                    'status' => 'refunded',
                    'refunded_at' => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('refunds.show', $refund)
                ->with('success', 'Refund processed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Refund processing failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to process refund: ' . $e->getMessage()]);
        }
    }
}
