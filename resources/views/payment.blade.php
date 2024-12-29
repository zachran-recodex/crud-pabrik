<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pembayaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($order && $order->items->count() > 0)
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-semibold">Detail Keranjang Belanja</h3>
                    <div class="mt-6">
                        @foreach($order->items as $item)
                            <div class="flex justify-between items-center border-b py-4">
                                <div class="flex items-center">
                                    <img class="w-16 h-16 object-cover rounded" src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                                    <span class="ml-4">{{ $item->product->name }}</span>
                                </div>
                                <span class="text-gray-900">x {{ $item->quantity }}</span>
                                <span class="text-gray-900">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex justify-between items-center">
                        <span class="font-semibold">Total: Rp {{ number_format($order->items->sum(function($item) {
                            return $item->product->price * $item->quantity;
                        }), 0, ',', '.') }}</span>
                    </div>

                    <form action="{{ route('checkout.complete') }}" method="POST" class="mt-6">
                        @csrf
                        <div class="mb-4">
                            <label for="payment_method" class="block text-gray-700">Metode Pembayaran</label>
                            <select id="payment_method" name="payment_method" class="w-full border-gray-300 rounded-md">
                                <option value="credit_card">Kartu Kredit</option>
                                <option value="bank_transfer">Transfer Bank</option>
                                <option value="cash_on_delivery">Bayar di Tempat</option>
                            </select>
                        </div>

                        <div class="mt-6 text-right">
                            <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
                                Selesaikan Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <p class="text-center text-gray-500 mt-6">Keranjang Anda kosong.</p>
            @endif
        </div>
    </div>
</x-app-layout>
