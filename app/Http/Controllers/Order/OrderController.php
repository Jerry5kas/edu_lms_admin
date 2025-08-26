<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders (admin)
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.course'])
            ->withCount('items')
            ->latest();

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by user
        if ($request->has('user_id') && $request->user_id !== '') {
            $query->where('user_id', $request->user_id);
        }

        // Search by gateway order ID
        if ($request->has('search') && $request->search !== '') {
            $query->where('gateway_order_id', 'like', '%' . $request->search . '%');
        }

        $orders = $query->paginate(15);
        $users = User::select('id', 'name', 'email')->get();
        $statuses = ['pending', 'paid', 'failed', 'cancelled', 'refunded'];

        // Stats
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'paid')->sum('total_cents') / 100,
            'pending_orders' => Order::where('status', 'pending')->count(),
            'failed_orders' => Order::where('status', 'failed')->count(),
        ];

        return view('order.orders.index', compact('orders', 'users', 'statuses', 'stats'));
    }



    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.course', 'payments', 'invoice']);
        
        return view('order.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order
     */
    public function edit(Order $order)
    {
        $order->load(['items.course']);
        $courses = Course::where('is_published', true)->get();
        $users = User::all();
        
        return view('order.orders.edit', compact('order', 'courses', 'users'));
    }

    /**
     * Update the specified order
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,failed,cancelled,refunded',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Update status timestamps
        $updateData = [
            'status' => $newStatus,
            'notes' => $request->notes ? ['admin_notes' => $request->notes] : $order->notes,
        ];

        // Set appropriate timestamp based on status change
        if ($oldStatus !== $newStatus) {
            switch ($newStatus) {
                case 'paid':
                    $updateData['paid_at'] = now();
                    break;
                case 'failed':
                    $updateData['failed_at'] = now();
                    break;
                case 'cancelled':
                    $updateData['cancelled_at'] = now();
                    break;
                case 'refunded':
                    $updateData['refunded_at'] = now();
                    break;
            }
        }

        $order->update($updateData);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order updated successfully!');
    }

    /**
     * Remove the specified order
     */
    public function destroy(Order $order)
    {
        // Only allow deletion of pending orders
        if ($order->status !== 'pending') {
            return back()->withErrors(['error' => 'Only pending orders can be deleted.']);
        }

        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully!');
    }

    /**
     * Cancel order (admin action)
     */
    public function cancel(Order $order)
    {
        // Only allow cancellation of pending orders
        if ($order->status !== 'pending') {
            return back()->withErrors(['error' => 'Only pending orders can be cancelled.']);
        }

        $order->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Order cancelled successfully!');
    }
}
