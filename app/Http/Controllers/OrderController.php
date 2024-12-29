<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function confirm(Order $order)
    {
        $order->status = 'completed';
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order berhasil dikonfirmasi.');
    }

    public function show(Order $order)
    {
        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        if ($order->status === 'pending') {
            $order->update(['status' => 'cancelled']);
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order berhasil dibatalkan.');
        }

        return redirect()->route('orders.show', $order->id)
            ->with('error', 'Order tidak dapat dibatalkan.');
    }

    public function process(Order $order)
    {
        if (in_array($order->status, ['pending', 'confirmed'])) {
            $order->update(['status' => 'processing']);
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order sedang diproses.');
        }

        return redirect()->route('orders.show', $order->id)
            ->with('error', 'Order tidak dapat diproses.');
    }
}
