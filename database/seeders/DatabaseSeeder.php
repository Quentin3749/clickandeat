<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer 10 restaurants
        Restaurant::factory(10)->create();

        // Créer des catégories pour chaque restaurant
        Restaurant::all()->each(function ($restaurant) {
            Category::factory(rand(1, 5))->create([ // Créer entre 1 et 5 catégories par restaurant
                'restaurant_id' => $restaurant->id,
            ]);
        });
    }
}