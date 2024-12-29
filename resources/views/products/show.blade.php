<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Produk | {{ $product->name }}
            </h2>
            <a href="{{ route('products.index') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Gambar Produk -->
                <div class="flex justify-center items-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk"
                             class="w-full h-96 object-cover rounded-lg shadow-md">
                    @else
                        <div class="w-full h-96 bg-gray-200 rounded-lg flex justify-center items-center">
                            <span class="text-gray-500">Tidak ada gambar</span>
                        </div>
                    @endif
                </div>

                <!-- Detail Produk -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-800">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $product->description }}</p>
                    </div>

                    <div class="text-lg font-semibold text-gray-900">
                        Harga: <span class="text-xl text-green-600">{{ $product->formatted_price }}</span>
                    </div>

                    <div class="text-lg font-semibold text-gray-900">
                        Stok: <span class="text-xl">{{ $product->stock }}</span>
                    </div>

                    <div>
                        <span class="px-3 py-1 rounded-full text-white {{ $product->is_active ? 'bg-green-500' : 'bg-red-500' }}">
                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-4 flex space-x-4">
                        <a href="{{ route('products.edit', $product) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg shadow">
                            Edit Produk
                        </a>

                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow"
                                    onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                Hapus Produk
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
