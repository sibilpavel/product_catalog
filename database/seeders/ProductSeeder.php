<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        for ($i = 1; $i <= 30; $i++) {
            Product::create([
                'name' => "Product $i",
                'description' => "Description for product $i",
                'price' => rand(10, 500),
                'category_id' => $categories->random()->id,
            ]);
        }
    }
}
