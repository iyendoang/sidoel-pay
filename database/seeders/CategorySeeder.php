<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'image' => 'images/cash-machine.png',
            'name' => 'SDQ',
            'created_by' => '1',
            'updated_by' => '1',
            'description' => 'Server SDQ'
        ]);
    }
}
