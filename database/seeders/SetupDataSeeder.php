<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SetupDataSeeder extends Seeder

{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()
            ->count(10)
            ->has(Category::factory()->count(3))
            ->has(Image::factory()->count(3))
            ->create();
    }
}
