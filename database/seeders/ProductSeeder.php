<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Apple iPhone 14',
            'slug' => Str::slug('Apple iPhone 14'),
            'description' => 'Smartphone terbaru dari Apple dengan layar Super Retina XDR 6,1 inci dan chip A16 Bionic.',
            'price' => 14999999, // Harga dalam rupiah
            'stock' => 50,
            'image' => 'iphone14.jpg', // Gambar produk
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Samsung Galaxy S23 Ultra',
            'slug' => Str::slug('Samsung Galaxy S23 Ultra'),
            'description' => 'Smartphone flagship dari Samsung dengan layar Dynamic AMOLED 6,8 inci dan kamera 200 MP.',
            'price' => 18999999, // Harga dalam rupiah
            'stock' => 30,
            'image' => 'galaxy-s23-ultra.jpg',
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Sony WH-1000XM5 Headphones',
            'slug' => Str::slug('Sony WH-1000XM5 Headphones'),
            'description' => 'Headphone noise-cancelling terbaik dengan baterai hingga 30 jam dan kualitas suara luar biasa.',
            'price' => 4999999, // Harga dalam rupiah
            'stock' => 100,
            'image' => 'sony-wh1000xm5.jpg',
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'MacBook Pro 14-inch M2',
            'slug' => Str::slug('MacBook Pro 14-inch M2'),
            'description' => 'Laptop kelas atas dengan chip M2, layar Liquid Retina XDR, dan daya tahan baterai luar biasa.',
            'price' => 27999999, // Harga dalam rupiah
            'stock' => 15,
            'image' => 'macbook-pro-m2.jpg',
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Xiaomi Smart Band 8',
            'slug' => Str::slug('Xiaomi Smart Band 8'),
            'description' => 'Smartband dengan layar AMOLED, berbagai mode olahraga, dan daya tahan baterai hingga 14 hari.',
            'price' => 599999, // Harga dalam rupiah
            'stock' => 200,
            'image' => 'xiaomi-smartband-8.jpg',
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Logitech MX Master 3S',
            'slug' => Str::slug('Logitech MX Master 3S'),
            'description' => 'Mouse wireless premium dengan scroll elektromagnetik MagSpeed dan desain ergonomis.',
            'price' => 1799999, // Harga dalam rupiah
            'stock' => 75,
            'image' => 'logitech-mx-master-3s.jpg',
            'is_active' => true,
        ]);
    }
}
