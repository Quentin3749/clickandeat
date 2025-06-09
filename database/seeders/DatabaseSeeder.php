<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Database\Seeders\RestaurantSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer d'abord les restaurants
        $this->call([
            RestaurantSeeder::class
        ]);

        // Créer 10 restaurants supplémentaires
        Restaurant::factory(10)->create();

        // Ajouter les catégories par défaut à tous les restaurants
        $this->call([
            CategorySeeder::class
        ]);
    }
}