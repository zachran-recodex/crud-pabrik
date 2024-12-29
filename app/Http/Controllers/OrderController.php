<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        // Mengambil semua orderan dengan relasi item produk
        $orders = Order::with('items.product')->get();
        return view('orders.index', compact('orders'));
    }

    // Mengonfirmasi orderan
    public function confirm(Order $order)
    {
        // Mengubah status order menjadi 'completed'
        $order->status = 'completed';
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order berhasil dikonfirmasi.');
    }

    public function show(Order $order)
    {
        $order->load('items.product'); // Load relasi untuk detail barang
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
