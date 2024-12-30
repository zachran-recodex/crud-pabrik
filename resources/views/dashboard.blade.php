<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if(Auth::user()->hasRole('user'))
                    Online Shop
                @else
                    Laporan Penjualan
                @endif
            </h2>
            @if(Auth::user()->hasRole('user'))
                <div class="flex items-center">
                    @php
                        $order = \App\Models\Order::where('user_id', auth()->id())->where('status', 'pending')->first();
                        $orderItemCount = $order ? $order->items->sum('quantity') : 0;
                    @endphp
                    <a href="{{ route('cart.checkout') }}" class="flex items-center bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        <span>Keranjang ({{ $orderItemCount }})</span>
                    </a>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(Auth::user()->hasRole('super admin'))
                <div class="mb-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <!-- Widget: Jumlah Customer -->
                        <div class="bg-white p-6 border border-gray-200 rounded-lg shadow-md text-center">
                            <h4 class="text-lg font-semibold text-gray-800">Jumlah Customer</h4>
                            <p class="text-xl font-bold text-blue-500 mt-2">{{ $customerCount }}</p>
                        </div>

                        <!-- Widget: Jumlah Orderan -->
                        <div class="bg-white p-6 border border-gray-200 rounded-lg shadow-md text-center">
                            <h4 class="text-lg font-semibold text-gray-800">Jumlah Orderan</h4>
                            <p class="text-xl font-bold text-blue-500 mt-2">{{ $orderCount }}</p>
                        </div>

                        <!-- Widget: Total Pemasukan -->
                        <div class="bg-white p-6 border border-gray-200 rounded-lg shadow-md text-center">
                            <h4 class="text-lg font-semibold text-gray-800">Total Pemasukan</h4>
                            <p class="text-xl font-bold text-green-500 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>

                        <!-- Widget: Orderan Berhasil -->
                        <div class="bg-white p-6 border border-gray-200 rounded-lg shadow-md text-center">
                            <h4 class="text-lg font-semibold text-gray-800">Orderan Berhasil</h4>
                            <p class="text-xl font-bold text-green-500 mt-2">{{ $successfulOrders }}</p>
                        </div>
                    </div>

                    <!-- Tambahan: Daftar Orderan Tertinggi -->
                    <div class="mt-8 bg-white p-6 border border-gray-200 rounded-lg shadow-md">
                        <h4 class="text-lg font-semibold text-gray-800">Orderan Terbaru</h4>
                        <div class="overflow-x-auto mt-4">
                            <table class="min-w-full text-sm">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-3 text-left">Customer</th>
                                    <th class="px-6 py-3 text-left">Jumlah Produk</th>
                                    <th class="px-6 py-3 text-left">Total Harga</th>
                                    <th class="px-6 py-3 text-left">Status</th>
                                    <th class="px-6 py-3 text-left">Tanggal</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="px-6 py-4">{{ $order->user->name }}</td>
                                        <td class="px-6 py-4">{{ $order->items->sum('quantity') }}</td>
                                        <td class="px-6 py-4">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">{{ ucfirst($order->status) }}</td>
                                        <td class="px-6 py-4">{{ $order->created_at->format('d-m-Y') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="mt-6">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($products as $product)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
                            <img class="w-full h-48 object-cover object-center" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">

                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h3>
                                <p class="text-gray-500 mt-2 text-sm">{{ Str::limit($product->description, 50) }}</p>
                                <p class="text-xl font-semibold text-gray-900 mt-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                                <div class="mt-4">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">
                                            Masukkan ke Keranjang
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 mt-6">Tidak ada produk yang tersedia.</p>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
