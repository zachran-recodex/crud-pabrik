<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Order
            </h2>
            <a href="{{ route('orders.index') }}"
               class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4">Order #{{ $order->id }} | {{ $order->user->name }}</h3>

                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d-m-Y H:i:s') }}</p>
                <p><strong>Metode Pembayaran:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>

                <p class="flex justify-between items-center pt-2">
                    <strong>Status:</strong>
                    <span class="{{
                          $order->status === 'pending' ? 'inline-block px-4 py-1 rounded-full bg-yellow-100 text-yellow-800' :
                          ($order->status === 'completed' ? 'inline-block px-4 py-1 rounded-full bg-green-100 text-green-800' :
                          ($order->status === 'cancelled' ? 'inline-block px-4 py-1 rounded-full bg-red-100 text-red-800' :
                          ($order->status === 'processing' ? 'inline-block px-4 py-1 rounded-full bg-blue-100 text-blue-800' :
                          'inline-block px-4 py-1 rounded-full bg-gray-100 text-gray-800')))
                      }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>

                <h4 class="mt-6 text-lg font-semibold">Detail Barang:</h4>
                <ul>
                    @foreach ($order->items as $item)
                        <li class="flex justify-between items-center py-2 border-b">
                            <div class="flex items-center">
                                <img class="w-16 h-16 object-cover rounded" src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                                <span class="ml-4">{{ $item->product->name }}</span>
                            </div>
                            <span class="text-gray-900">x{{ $item->quantity }}</span>
                            <span class="text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>

                <p class="flex justify-between items-center py-2"><strong>Total Pembayaran:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</p>

                <div class="mt-6 flex space-x-4">
                    @if($order->status === 'pending')
                        <form action="{{ route('orders.confirm', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
                                Konfirmasi Order
                            </button>
                        </form>

                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">
                                Batalkan Order
                            </button>
                        </form>
                    @endif

                    @if($order->status === 'pending' || $order->status === 'confirmed')
                        <form action="{{ route('orders.process', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                Proses Order
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
