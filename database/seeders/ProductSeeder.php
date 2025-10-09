<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            ['name' => 'Cat', 'price' => 10000, 'stock' => 50, 'discount' => 5],
            ['name' => 'Paku', 'price' => 8000, 'stock' => 40, 'discount' => 10],
            ['name' => 'Papan', 'price' => 15000, 'stock' => 30, 'discount' => 15],
            ['name' => 'Kawat', 'price' => 12000, 'stock' => 25, 'discount' => 20],
            ['name' => 'Kuas', 'price' => 5000, 'stock' => 100, 'discount' => 25],
        ]);
    }
}
