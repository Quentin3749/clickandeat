<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

/**
 * Contrôleur de la page d'accueil
 *
 * Affiche la liste des restaurants avec options de filtrage (nom, cuisine, prix).
 */
class HomeController extends Controller
{
    /**
     * Constructeur du contrôleur
     *
     * Par défaut, pas de middleware d'authentification pour permettre l'accès public à la liste des restaurants.
     */
    public function __construct()
    {
        // Retirer le middleware auth pour permettre aux visiteurs de voir les restaurants
        // $this->middleware('auth');
    }

    /**
     * Affiche la page d'accueil avec la liste filtrée des restaurants
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Initialise la requête sur le modèle Restaurant
        $query = Restaurant::query();

        // Filtrage par nom (si le champ 'search' est présent dans la requête)
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filtrage par type de cuisine (si le champ 'cuisine' est présent)
        if ($request->has('cuisine')) {
            $query->where('cuisine_type', $request->cuisine);
        }

        // Filtrage par gamme de prix (si le champ 'price' est présent)
        if ($request->has('price')) {
            $query->where('price_range', $request->price);
        }

        // Récupère les restaurants paginés (12 par page)
        $restaurants = $query->paginate(12);
        // Récupère les types de cuisine distincts
        $cuisineTypes = Restaurant::distinct()->pluck('cuisine_type')->filter();
        // Récupère les gammes de prix distinctes
        $priceRanges = Restaurant::distinct()->pluck('price_range')->filter();

        // Retourne la vue 'home' avec les données nécessaires
        return view('home', compact('restaurants', 'cuisineTypes', 'priceRanges'));
    }
}
