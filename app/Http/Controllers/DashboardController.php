<?php

namespace App\Http\Controllers;

use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::active()->paginate(8);

        return view('dashboard', compact('products'));
    }
}
