<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    // Affiche la liste de tous les restaurants pour l'espace client
    public function index()
    {
        $restaurants = Restaurant::all();
        return view('dashboard.restaurants', compact('restaurants'));
    }
}
