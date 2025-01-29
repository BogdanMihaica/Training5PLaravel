<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cats = [
            ['title' => 'Persian Cat', 'description' => 'A fluffy and affectionate cat with a luxurious coat.', 'price' => 1200.99],
            ['title' => 'Maine Coon', 'description' => 'A large and sociable breed known for its tufted ears and bushy tail.', 'price' => 1500.50],
            ['title' => 'Siamese Cat', 'description' => 'A sleek and vocal breed with striking blue eyes.', 'price' => 900.75],
            ['title' => 'Bengal Cat', 'description' => 'A wild-looking breed with a beautifully spotted coat.', 'price' => 1800.00],
            ['title' => 'Sphynx Cat', 'description' => 'A hairless breed that is friendly and loves warmth.', 'price' => 1300.25],
            ['title' => 'Ragdoll Cat', 'description' => 'A gentle and relaxed breed with striking blue eyes.', 'price' => 1400.99],
            ['title' => 'British Shorthair', 'description' => 'A chunky, plush-coated breed with a calm personality.', 'price' => 1100.00],
            ['title' => 'Scottish Fold', 'description' => 'Known for its folded ears and round face.', 'price' => 1250.49],
            ['title' => 'Abyssinian', 'description' => 'A playful and intelligent breed with a ticked coat.', 'price' => 1000.89],
            ['title' => 'Norwegian Forest Cat', 'description' => 'A strong and fluffy breed adapted for cold climates.', 'price' => 1450.99],
            ['title' => 'Oriental Shorthair', 'description' => 'A slender breed with large ears and a sleek coat.', 'price' => 1050.75],
            ['title' => 'Turkish Angora', 'description' => 'A graceful and intelligent breed with a fine, silky coat.', 'price' => 1350.60],
            ['title' => 'Russian Blue', 'description' => 'A quiet and elegant breed with a shimmering blue-gray coat.', 'price' => 1150.30],
            ['title' => 'Burmese Cat', 'description' => 'A muscular and friendly breed with a soft coat.', 'price' => 980.45],
            ['title' => 'Devon Rex', 'description' => 'A quirky breed with large ears and a short, curly coat.', 'price' => 1080.90],
        ];

        foreach ($cats as $cat) {
            Product::factory()->create($cat);
        }
    }
}
