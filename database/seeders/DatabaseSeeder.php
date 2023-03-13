<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $product[] = [
            'nama_produk' => 'Item 1',
            'harga' => 160000,
            'stock' => 18,
            'image' => 'shop-1.jpg'
        ];
        $product[] = [
            'nama_produk' => 'Item 2',
            'harga' => 120000,
            'stock' => 48,
            'image' => 'shop-2.jpg'
        ];
        $product[] = [
            'nama_produk' => 'Item 3',
            'harga' => 260000,
            'stock' => 59,
            'image' => 'shop-3.jpg'
        ];
        $product[] = [
            'nama_produk' => 'Item 4',
            'harga' => 200000,
            'stock' => 99,
            'image' => 'shop-4.jpg'
        ];
        $product[] = [
            'nama_produk' => 'Item 5',
            'harga' => 160000,
            'stock' => 18,
            'image' => 'shop-5.jpg'
        ];
        $product[] = [
            'nama_produk' => 'Item 6',
            'harga' => 120000,
            'stock' => 48,
            'image' => 'shop-6.jpg'
        ];
        $product[] = [
            'nama_produk' => 'Item 7',
            'harga' => 260000,
            'stock' => 59,
            'image' => 'shop-7.jpg'
        ];
        $product[] = [
            'nama_produk' => 'Item 8',
            'harga' => 200000,
            'stock' => 99,
            'image' => 'shop-8.jpg'
        ];
        $product[] = [
            'nama_produk' => 'Item 9',
            'harga' => 290000,
            'stock' => 110,
            'image' => 'shop-9.jpg'
        ];

        foreach ($product as $p) {
            Product::create([
                'nama_produk' => $p['nama_produk'],
                'stock' => $p['stock'],
                'harga' => $p['harga'],
                'image' => $p['image'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
