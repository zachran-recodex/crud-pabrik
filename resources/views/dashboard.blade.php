<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
            <div class="flex items-center">
                @php
                    $order = \App\Models\Order::where('user_id', auth()->id())->where('status', 'pending')->first();
                    $orderItemCount = $order ? $order->items->sum('quantity') : 0;
                @endphp
                <a href="{{ route('cart.checkout') }}" class="flex items-center bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                    <span>Keranjang ({{ $orderItemCount }})</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

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
        </div>
    </div>
</x-app-layout>
