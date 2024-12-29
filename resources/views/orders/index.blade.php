<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Order
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tampilkan pesan sukses jika ada -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4">Daftar Orderan</h3>
                <table class="min-w-full table-auto">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Order ID</th>
                        <th class="px-4 py-2 text-left">Nama User</th> <!-- Kolom baru -->
                        <th class="px-4 py-2 text-left">Tanggal</th>
                        <th class="px-4 py-2 text-left">Total</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $order->id }}</td>
                            <td class="px-4 py-2">{{ $order->user->name ?? 'Guest' }}</td> <!-- Menampilkan nama user -->
                            <td class="px-4 py-2">{{ $order->created_at->format('d-m-Y H:i:s') }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">
                <span class="{{
                      $order->status === 'pending' ? 'inline-block px-4 py-1 rounded-full bg-yellow-100 text-yellow-800' :
                      ($order->status === 'completed' ? 'inline-block px-4 py-1 rounded-full bg-green-100 text-green-800' :
                      ($order->status === 'cancelled' ? 'inline-block px-4 py-1 rounded-full bg-red-100 text-red-800' :
                      ($order->status === 'processing' ? 'inline-block px-4 py-1 rounded-full bg-blue-100 text-blue-800' :
                      'inline-block px-4 py-1 rounded-full bg-gray-100 text-gray-800')))
                  }}">
                    {{ ucfirst($order->status) }}
                </span>
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('orders.show', $order->id) }}"
                                   class="bg-blue-500 text-white py-1 px-4 rounded hover:bg-blue-600">
                                    Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
