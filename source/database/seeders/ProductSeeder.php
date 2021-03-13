<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
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
        Product::factory(10)->create()->each(function ($product) {
            return $product->categories()->attach(Category::limit(3)->pluck('id')->toArray());
        });
    }
}
