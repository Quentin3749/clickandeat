<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\User; // Ajout de l'importation du modèle User
use App\Models\Item; // Assurez-vous d'importer le modèle Item
use Illuminate\View\View;

class RestaurantsController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with('user')->get();
        return view("restaurants.index", ['restaurants' => $restaurants]);
    }

    public function create()
    {
        $users = User::where('role', 'restaurateur')->get();
        return view("restaurants.create", ['users' => $users]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        Restaurant::create($request->all());

        return redirect()->route("restaurants.index")->with('success', 'Restaurant créé avec succès.');
    }

    public function show($id)
    {
        $restaurant = Restaurant::with('user')->findOrFail($id); // Charger la relation user
        return view('restaurants.show', ['restaurant' => $restaurant]);
    }

    public function edit($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $users = User::where('role', 'restaurateur')->get();
        return view('restaurants.edit', ['restaurant' => $restaurant, 'users' => $users]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $restaurant = Restaurant::findOrFail($id);
        $restaurant->update($request->all());

        return redirect()->route('restaurants.index')->with('success', 'Restaurant mis à jour avec succès.');
    }

    public function destroy(Request $request, $id)
    {
        if ($request->get('id') == $id) {
            Restaurant::destroy($id);
            return redirect()->route('restaurants.index')->with('success', 'Restaurant supprimé avec succès.');
        }

        return redirect()->route('restaurants.index')->with('error', 'Impossible de supprimer le restaurant.');
    }

    public function showCategories($restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
        $categories = $restaurant->categories;

        return view('restaurants.categories', [
            'restaurant' => $restaurant,
            'categories' => $categories,
        ]);
    }

    /**
     * Affiche le menu d'un restaurant spécifique.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\View\View
     */
    public function showMenu(Restaurant $restaurant): View
    {
        // Récupérer tous les items associés à ce restaurant
        $menuItems = Item::where('restaurant_id', $restaurant->id)->with('category')->get()->groupBy('category.name');

        // Passer le restaurant et les items à la vue
        return view('restaurants.menu', compact('restaurant', 'menuItems'));
    }

    /**
     * Get the items for the specified restaurant (for AJAX request).
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function getItems(Restaurant $restaurant)
    {
        $items = Item::where('restaurant_id', $restaurant->id)->get();
        return response()->json($items);
    }
}