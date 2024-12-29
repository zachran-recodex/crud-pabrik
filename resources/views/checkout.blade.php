<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Checkout
            </h2>
            <a href="{{ route('dashboard') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if($order && $order->items->count() > 0)
                <div class="bg-white shadow-md rounded-lg p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-semibold">Keranjang Belanja</h3>

                        <form action="{{ route('cart.clear') }}" method="POST" class="text-center">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">
                                Hapus Semua Produk
                            </button>
                        </form>
                    </div>
                    <div class="mt-6">
                        @foreach($order->items as $item)
                            <div class="flex justify-between items-center border-b py-4">
                                <div class="flex items-center">
                                    <img class="w-16 h-16 object-cover rounded" src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                                    <span class="ml-4">{{ $item->product->name }} x{{ $item->quantity }}</span>
                                </div>
                                <span class="text-gray-900">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>

                                <form action="{{ route('cart.removeItem', $item->id) }}" method="POST" class="ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex justify-between items-center">
                        <span class="font-semibold">Total: Rp {{ number_format($order->items->sum(function($item) {
                            return $item->product->price * $item->quantity;
                        }), 0, ',', '.') }}</span>

                        <a href="{{ route('checkout.payment') }}" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
                            Proses Checkout
                        </a>
                    </div>
                </div>
            @else
                <p class="text-center text-gray-500 mt-6">Keranjang Anda kosong.</p>
            @endif
        </div>
    </div>
</x-app-layout>
