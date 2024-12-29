<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pembayaran Berhasil
            </h2>
            <a href="{{ route('dashboard') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                <!-- Header Order -->
                <div class="text-center">
                    <h3 class="text-xl font-bold text-gray-800">Terima kasih telah membeli produk kami!</h3>
                    <p class="text-gray-600 text-sm mb-4">Order #{{ $order->id }}</p>
                    <div class="border-t border-gray-300 pt-2"></div>
                </div>

                <!-- Order Status -->
                <div class="text-center mt-4">
                    <h3 class="text-lg font-semibold">Status:
                        <span class="{{
                                  $order->status === 'pending' ? 'inline-block px-4 py-1 rounded-full bg-yellow-100 text-yellow-800' :
                                  ($order->status === 'completed' ? 'inline-block px-4 py-1 rounded-full bg-green-100 text-green-800' :
                                  ($order->status === 'cancelled' ? 'inline-block px-4 py-1 rounded-full bg-red-100 text-red-800' :
                                  ($order->status === 'processing' ? 'inline-block px-4 py-1 rounded-full bg-blue-100 text-blue-800' :
                                  'inline-block px-4 py-1 rounded-full bg-gray-100 text-gray-800')))
                              }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </h3>
                    <p class="text-gray-500 text-sm">Tanggal: {{ $order->created_at->format('d-m-Y H:i:s') }}</p>
                </div>

                <!-- Order Details -->
                <div class="mt-6">
                    <p class="font-semibold">Total Pembayaran: Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    <p class="font-semibold">Metode Pembayaran: {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>

                    <h4 class="mt-6 text-lg font-semibold">Detail Barang:</h4>
                    <ul class="mt-2">
                        @foreach ($order->items as $item)
                            <li class="flex justify-between items-center py-2 border-b text-sm">
                                <div class="flex items-center">
                                    <img class="w-16 h-16 object-cover rounded" src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                                    <span class="ml-4">{{ $item->product->name }}</span>
                                </div>

                                <span class="text-gray-900">x{{ $item->quantity }}</span>

                                <span class="text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Footer -->
                <div class="border-t border-gray-300 pt-4 mt-6">
                    <p class="text-center text-sm text-gray-500">Kami akan segera memproses pesanan Anda.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
