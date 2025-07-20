<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jacketCategory = Category::where('name', 'Jackets')->first();
        $SetCategory = Category::where('name', '2pcs/Set')->first();

        Product::create([
            'category_id' => $jacketCategory->id,
            'name' => 'Modern Blue Jacket',
            'description' => 'A stylish blue jacket for modern fashion.',
            'price' => 79.99,
            'image' => 'images/blueHoodie0.jpg',
            'gallery_images' => json_encode(['images/blueHoodie0.jpg', 'images/blue1.jpg']),
            'stock' => 10,
        ]);

        Product::create([
            'category_id' => $SetCategory->id,
            'name' => 'Sport Sneakers',
            'description' => 'Comfortable running shoes for daily wear.',
            'price' => 59.99,
            'image' => 'images/blueWhiteHoodie0.jpg',
            'gallery_images' => json_encode(['images/blueWhiteHoodie0.jpg', 'images/blueWhiteHoodie1.jpg']),
            'stock' => 15,
        ]);
    }
}
