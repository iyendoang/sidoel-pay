<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'category_id' => 1,
            'image' => 'images/cash-machine.png',
            'barcode' => '001',
            'title' => 'Hosting RDM Raport DIgital Madrasah',
            'description' => 'Hosting RDM Raport DIgital Madrasah',
            'buy_price' => '0',
            'sell_price' => '350000',
            'stock' => '20',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
    }
}
