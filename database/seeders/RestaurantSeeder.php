<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        // Créer un utilisateur restaurateur si nécessaire
        $restaurateur = User::firstOrCreate(
            ['email' => 'resto@example.com'],
            [
                'name' => 'Restaurant Demo',
                'password' => bcrypt('password'),
                'role' => 'restaurateur'
            ]
        );

        // Restaurants de démonstration
        $restaurants = [
            [
                'name' => 'Le Ratatouille',
                'description' => "Le célèbre bistrot parisien du film Ratatouille, où l'on mange comme un chef !",
                'address' => '5 rue des Gourmets, Paris',
                'price_range' => '€€€',
                'cuisine_type' => 'Française',
                'image_url' => 'https://static.wikia.nocookie.net/pixar/images/6/6e/Ratatouille_restaurant.png'
            ],
            [
                'name' => 'The Krusty Krab',
                'description' => 'La meilleure enseigne de burgers sous-marins de Bikini Bottom (SpongeBob) !',
                'address' => '1 Ocean Avenue, Bikini Bottom',
                'price_range' => '€',
                'cuisine_type' => 'Fast Food',
                'image_url' => 'https://static.wikia.nocookie.net/spongebob/images/2/2b/Krusty_Krab_Exterior.png'
            ],
            [
                'name' => 'The Continental',
                'description' => 'L’hôtel-restaurant mythique réservé aux assassins, vu dans John Wick.',
                'address' => '1 John Wick Plaza, New York',
                'price_range' => '€€€€',
                'cuisine_type' => 'Gastronomique',
                'image_url' => 'https://static.wikia.nocookie.net/johnwick/images/0/0c/The_Continental.png'
            ],
            [
                'name' => "Central Perk",
                'description' => 'Le café culte où se retrouvent les Friends à New York.',
                'address' => '90 Bedford St, New York',
                'price_range' => '€€',
                'cuisine_type' => 'Café',
                'image_url' => 'https://static.wikia.nocookie.net/friends/images/7/7c/Central_Perk.png'
            ],
            [
                'name' => 'Los Pollos Hermanos',
                'description' => 'La chaîne de poulet la plus célèbre du Nouveau-Mexique (Breaking Bad).',
                'address' => '4257 Isleta Blvd SW, Albuquerque',
                'price_range' => '€€',
                'cuisine_type' => 'Américaine',
                'image_url' => 'https://static.wikia.nocookie.net/breakingbad/images/2/2d/Los_Pollos_Hermanos.png'
            ],
            [
                'name' => 'Moe’s Tavern',
                'description' => 'Le bar incontournable de Springfield (Les Simpson).',
                'address' => '742 Evergreen Terrace, Springfield',
                'price_range' => '€',
                'cuisine_type' => 'Bar',
                'image_url' => 'https://static.wikia.nocookie.net/simpsons/images/7/7c/Moe%27s_Tavern.png'
            ],
            [
                'name' => 'Jack Rabbit Slim’s',
                'description' => 'Le diner rétro de Pulp Fiction, célèbre pour ses milkshakes.',
                'address' => '101 Hollywood Blvd, Los Angeles',
                'price_range' => '€€',
                'cuisine_type' => 'Américaine',
                'image_url' => 'https://static.wikia.nocookie.net/tarantino/images/3/3a/JackRabbitSlims.png'
            ],
            [
                'name' => 'Monk’s Café',
                'description' => 'Le repaire new-yorkais de Jerry et ses amis (Seinfeld).',
                'address' => '2880 Broadway, New York',
                'price_range' => '€€',
                'cuisine_type' => 'Diner',
                'image_url' => 'https://static.wikia.nocookie.net/seinfeld/images/9/9e/MonksCafe.png'
            ],
            [
                'name' => 'The Double R Diner',
                'description' => 'Le diner mythique de Twin Peaks.',
                'address' => '137 W North Bend Way, Twin Peaks',
                'price_range' => '€€',
                'cuisine_type' => 'Diner',
                'image_url' => 'https://static.wikia.nocookie.net/twinpeaks/images/1/1a/Double_R_Diner.png'
            ],
        ];

        foreach ($restaurants as $restaurant) {
            Restaurant::create(array_merge($restaurant, ['user_id' => $restaurateur->id]));
        }
    }
}
