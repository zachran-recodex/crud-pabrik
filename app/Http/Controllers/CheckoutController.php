<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function add(Product $product)
    {
        $paymentMethod = 'pending';

        $order = Order::firstOrCreate(
            ['user_id' => auth()->id(), 'status' => 'pending'],
            ['total' => 0, 'payment_method' => $paymentMethod]
        );

        $orderItem = OrderItem::where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->first();

        if ($orderItem) {

            $orderItem->quantity++;
            $orderItem->save();
        } else {
            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price
            ]);
        }

        $total = $order->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $order->update(['total' => $total]);

        return redirect()->back()->with('success', 'Produk berhasil dimasukkan ke keranjang!');
    }

    public function checkout()
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if (!$order) {
            return redirect()->route('cart.checkout')->with('error', 'Keranjang Anda kosong.');
        }

        return view('checkout', compact('order'));
    }


    public function removeItem($itemId)
    {
        $order = Order::where('user_id', auth()->id())->where('status', 'pending')->first();

        if ($order) {
            $orderItem = OrderItem::where('order_id', $order->id)->where('id', $itemId)->first();

            if ($orderItem) {
                $orderItem->delete();
                return redirect()->route('cart.checkout')->with('success', 'Item berhasil dihapus dari keranjang!');
            }
        }

        return redirect()->route('cart.checkout')->with('error', 'Item tidak ditemukan!');
    }


    public function clear()
    {
        $order = Order::where('user_id', auth()->id())->where('status', 'pending')->first();

        if ($order) {
            $order->items()->delete();
            return redirect()->route('cart.checkout')->with('success', 'Semua produk telah dihapus dari keranjang!');
        }

        return redirect()->route('cart.checkout')->with('error', 'Keranjang Anda kosong!');
    }

    public function payment()
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if (!$order) {
            return redirect()->route('cart.checkout')->with('error', 'Keranjang Anda kosong.');
        }

        return view('payment', compact('order'));
    }

    public function complete(Request $request)
    {

        $validated = $request->validate([
            'payment_method' => 'required|in:credit_card,bank_transfer,cash_on_delivery',
        ]);

        $order = Order::where('user_id', auth()->id())->where('status', 'pending')->first();

        if (!$order || $order->items->count() == 0) {
            return redirect()->route('cart.checkout')->with('error', 'Keranjang Anda kosong.');
        }

        $order->update([
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
        ]);

        return redirect()->route('checkout.success', ['order' => $order]);
    }

    public function success(Order $order)
    {
        return view('success', [
            'order' => $order
        ]);
    }
}
