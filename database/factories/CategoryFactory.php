<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Restaurant;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(random_int(1, 3), true), // Génère 1 à 3 mots aléatoires
            'restaurant_id' => fake()->numberBetween(1, 10), // Assure que restaurant_id est entre 1 et 10
        ];
    }
}