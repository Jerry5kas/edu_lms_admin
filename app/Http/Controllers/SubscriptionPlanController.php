<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('subscription.index', compact('orders'));
    }


    public function create()
    {
        return view('subscription.create');
    }

    public function store(Request $request)
    {
        Order::create($request->all());
        return redirect()->route('subscriptions.index')->with('success', 'Order created!');
    }

    public function edit(Order $order)
    {
        return view('subscription.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return redirect()->route('subscriptions.index')->with('success', 'Order updated!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('subscriptions.index')->with('success', 'Order deleted!');
    }
}
