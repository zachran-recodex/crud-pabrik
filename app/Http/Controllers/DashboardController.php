<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('super admin')) {
            // Data untuk widget statistik
            $customerCount = User::count(); // Jumlah customer
            $orderCount = Order::count(); // Jumlah orderan
            $totalRevenue = Order::sum('total'); // Total pemasukan
            $successfulOrders = Order::where('status', 'completed')->count(); // Jumlah orderan berhasil

            // Data untuk daftar orderan terbaru
            $orders = Order::with('items.product')->orderBy('created_at', 'desc')->paginate(10);

            return view('dashboard', compact('customerCount', 'orderCount', 'totalRevenue', 'successfulOrders', 'orders'));
        }

        $products = Product::active()->paginate(8); // Ambil produk untuk pengguna biasa
        return view('dashboard', compact('products'));
    }
}
