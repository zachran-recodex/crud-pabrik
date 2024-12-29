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
        // Tentukan nilai default untuk payment_method
        $paymentMethod = 'pending';  // Atau Anda bisa memberikan nilai lain jika diperlukan

        // Ambil atau buat order untuk pengguna yang sedang login
        $order = Order::firstOrCreate(
            ['user_id' => auth()->id(), 'status' => 'pending'],
            ['total' => 0, 'payment_method' => $paymentMethod] // Menetapkan nilai default untuk payment_method saat pembuatan order baru
        );

        // Cek apakah produk sudah ada dalam order (order items)
        $orderItem = OrderItem::where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->first();

        if ($orderItem) {
            // Jika sudah ada, update quantity-nya
            $orderItem->quantity++;
            $orderItem->save();
        } else {
            // Jika belum ada, tambahkan item baru ke dalam order
            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price
            ]);
        }

        // Menghitung total harga setelah produk ditambahkan
        $total = $order->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        // Update nilai total pada order
        $order->update(['total' => $total]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Produk berhasil dimasukkan ke keranjang!');
    }

    public function checkout()
    {
        // Ambil atau buat order untuk pengguna yang sedang login
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if (!$order) {
            return redirect()->route('cart.checkout')->with('error', 'Keranjang Anda kosong.');
        }

        return view('checkout', compact('order'));
    }

    // Menghapus satu item dari order
    public function removeItem($itemId)
    {
        $order = Order::where('user_id', auth()->id())->where('status', 'pending')->first();

        if ($order) {
            $orderItem = OrderItem::where('order_id', $order->id)->where('id', $itemId)->first();

            if ($orderItem) {
                $orderItem->delete(); // Menghapus item dari order
                return redirect()->route('cart.checkout')->with('success', 'Item berhasil dihapus dari keranjang!');
            }
        }

        return redirect()->route('cart.checkout')->with('error', 'Item tidak ditemukan!');
    }

    // Menghapus semua item dari order
    public function clear()
    {
        $order = Order::where('user_id', auth()->id())->where('status', 'pending')->first();

        if ($order) {
            $order->items()->delete(); // Menghapus semua item dari order
            return redirect()->route('cart.checkout')->with('success', 'Semua produk telah dihapus dari keranjang!');
        }

        return redirect()->route('cart.checkout')->with('error', 'Keranjang Anda kosong!');
    }

    public function payment()
    {
        // Ambil order yang sedang diproses oleh pengguna yang sedang login
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
        // Validasi data pembayaran
        $validated = $request->validate([
            'payment_method' => 'required|in:credit_card,bank_transfer,cash_on_delivery',
        ]);

        // Ambil order pengguna yang sedang login
        $order = Order::where('user_id', auth()->id())->where('status', 'pending')->first();

        if (!$order || $order->items->count() == 0) {
            return redirect()->route('cart.checkout')->with('error', 'Keranjang Anda kosong.');
        }

        // Update status order dan pembayaran
        $order->update([
            'payment_method' => $validated['payment_method'],
            'status' => 'pending', // Status transaksi setelah selesai
        ]);

        // Redirect ke halaman konfirmasi pembayaran
        return redirect()->route('checkout.success', ['order' => $order]);
    }

    public function success(Order $order)
    {
        return view('success', [
            'order' => $order
        ]);
    }
}
