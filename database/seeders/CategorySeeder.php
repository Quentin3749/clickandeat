<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultCategories = ['Entrées', 'Plats', 'Desserts', 'Boissons'];
        foreach (Restaurant::all() as $restaurant) {
            foreach ($defaultCategories as $cat) {
                Category::firstOrCreate([
                    'name' => $cat,
                    'restaurant_id' => $restaurant->id
                ]);
            }
        }
    }
}
