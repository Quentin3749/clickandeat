<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\User; // Ajout de l'importation du modèle User
use App\Models\Item; // Assurez-vous d'importer le modèle Item
use Illuminate\View\View;

/**
 * Contrôleur de gestion des restaurants
 *
 * Permet de lister, créer, afficher, modifier et supprimer des restaurants.
 */
class RestaurantsController extends Controller
{
    /**
     * Affiche la liste de tous les restaurants
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupère tous les restaurants avec leur utilisateur associé
        $restaurants = Restaurant::with('user')->get();
        return view("restaurants.index", ['restaurants' => $restaurants]);
    }

    /**
     * Affiche le formulaire de création d'un restaurant
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Formulaire dédié au restaurateur connecté
        return view("restaurateur.create_restaurant");
    }

    /**
     * Enregistre un nouveau restaurant en base de données
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valide les champs du formulaire
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'cuisine_type' => 'required|string|max:255',
            'price_range' => 'required|string|max:10',
        ]);

        // Crée le restaurant et l'associe au restaurateur connecté
        Restaurant::create([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'cuisine_type' => $request->cuisine_type,
            'price_range' => $request->price_range,
            'user_id' => auth()->id(),
        ]);

        // Redirige vers le dashboard avec un message de succès
        return redirect('/restaurateur/dashboard')->with('success', 'Restaurant créé avec succès.');
    }

    /**
     * Affiche le détail d'un restaurant
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Récupère le restaurant avec son utilisateur associé
        $restaurant = Restaurant::with('user')->findOrFail($id); 
        return view('restaurants.show', ['restaurant' => $restaurant]);
    }

    /**
     * Affiche le formulaire d'édition d'un restaurant
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Récupère le restaurant à éditer
        $restaurant = Restaurant::findOrFail($id);
        // Récupère tous les utilisateurs ayant le rôle restaurateur pour lier le restaurant
        $users = User::where('role', 'restaurateur')->get();
        return view('restaurants.edit', ['restaurant' => $restaurant, 'users' => $users]);
    }

    /**
     * Met à jour un restaurant existant
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Valide les champs du formulaire
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'primary_color' => 'nullable|string|max:7',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Récupère le restaurant à mettre à jour
        $restaurant = Restaurant::findOrFail($id);
        // Met à jour les champs du restaurant
        $restaurant->name = $request->input('name');
        $restaurant->user_id = $request->input('user_id');
        $restaurant->primary_color = $request->input('primary_color');

        // Gère l'upload d'un logo si nécessaire
        if ($request->hasFile('logo_path')) {
            $logo = $request->file('logo_path');
            $logoName = 'logo_' . $restaurant->id . '_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->storeAs('public/logos', $logoName);
            $restaurant->logo_path = 'logos/' . $logoName;
        }

        // Enregistre les modifications
        $restaurant->save();

        // Redirige vers la liste des restaurants avec un message de succès
        return redirect()->route('restaurants.index')->with('success', 'Restaurant mis à jour avec succès.');
    }

    /**
     * Supprime un restaurant
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        // Vérifie si l'utilisateur a les droits pour supprimer le restaurant
        if ($request->get('id') == $id) {
            // Supprime le restaurant
            Restaurant::destroy($id);
            // Redirige vers la liste des restaurants avec un message de succès
            return redirect()->route('restaurants.index')->with('success', 'Restaurant supprimé avec succès.');
        }

        // Redirige vers la liste des restaurants avec un message d'erreur
        return redirect()->route('restaurants.index')->with('error', 'Impossible de supprimer le restaurant.');
    }

    /**
     * Affiche les catégories d'un restaurant
     * @param int $restaurantId
     * @return \Illuminate\View\View
     */
    public function showCategories($restaurantId)
    {
        // Récupère le restaurant
        $restaurant = Restaurant::findOrFail($restaurantId);
        // Récupère les catégories du restaurant
        $categories = $restaurant->categories;

        // Affiche les catégories
        return view('restaurants.categories', [
            'restaurant' => $restaurant,
            'categories' => $categories,
        ]);
    }

    /**
     * Affiche le menu d'un restaurant
     * @param \App\Models\Restaurant $restaurant
     * @return \Illuminate\View\View
     */
    public function showMenu(Restaurant $restaurant): View
    {
        // Récupère tous les items associés au restaurant
        $menuItems = Item::where('restaurant_id', $restaurant->id)->with('category')->get()->groupBy('category.name');

        // Affiche le menu
        return view('restaurants.menu', compact('restaurant', 'menuItems'));
    }

    /**
     * Récupère les items d'un restaurant pour une requête AJAX
     * @param \App\Models\Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function getItems(Restaurant $restaurant)
    {
        // Récupère les items du restaurant
        $items = Item::where('restaurant_id', $restaurant->id)->get();
        // Retourne les items en JSON
        return response()->json($items);
    }

    /**
     * Affiche la liste des restaurants du restaurateur connecté
     */
    public function mesRestaurants()
    {
        $restaurants = Restaurant::where('user_id', auth()->id())->get();
        return view('restaurateur.mon_restaurant', compact('restaurants'));
    }

    /**
     * Affiche le détail d'un restaurant appartenant au restaurateur connecté
     */
    public function showRestaurateur($id)
    {
        $restaurant = Restaurant::where('user_id', auth()->id())->findOrFail($id);
        return view('restaurateur.show_restaurant', compact('restaurant'));
    }

    /**
     * Affiche le formulaire d'édition d'un restaurant (restaurateur)
     */
    public function editRestaurateur($id)
    {
        $restaurant = Restaurant::where('user_id', auth()->id())->findOrFail($id);
        return view('restaurateur.edit_restaurant', compact('restaurant'));
    }

    /**
     * Met à jour un restaurant (restaurateur)
     */
    public function updateRestaurateur(Request $request, $id)
    {
        $restaurant = Restaurant::where('user_id', auth()->id())->findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'cuisine_type' => 'required|string|max:255',
            'price_range' => 'required|string|max:10',
        ]);
        $restaurant->update($request->only(['name', 'description', 'address', 'cuisine_type', 'price_range']));
        return redirect()->route('restaurateur.restaurant.list')->with('success', 'Restaurant modifié avec succès.');
    }

    /**
     * Supprime un restaurant (restaurateur)
     */
    public function destroyRestaurateur($id)
    {
        $restaurant = Restaurant::where('user_id', auth()->id())->findOrFail($id);
        $restaurant->delete();
        return redirect()->route('restaurateur.restaurant.list');
    }

    /**
     * Affiche le formulaire d'ajout d'un plat (item) pour un restaurant
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function addItemForm($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return view('restaurateur.add_item', compact('restaurant'));
    }

    /**
     * Traite la soumission du formulaire d'ajout de plat
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeItem(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);

        // Validation des données du formulaire
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        // Création du plat dans la table items
        $item = new \App\Models\Item();
        $item->name = $request->input('name');
        $item->price = $request->input('price');
        $item->description = $request->input('description');
        $item->restaurant_id = $restaurant->id;
        $item->is_available = true;
        $item->save();

        return redirect()->route('restaurateur.restaurant.show', ['id' => $restaurant->id])
            ->with('success', 'Plat ajouté avec succès !');
    }

    /**
     * Supprime un plat du menu d'un restaurant
     * @param int $id
     * @param int $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteItem($id, $item)
    {
        $restaurant = Restaurant::findOrFail($id);
        $menu = $restaurant->menu;
        if (is_string($menu) && !empty($menu)) {
            $menu = json_decode($menu, true);
        }
        if (!is_array($menu)) {
            $menu = [];
        }
        if (isset($menu[$item])) {
            array_splice($menu, $item, 1);
            $restaurant->menu = $menu;
            $restaurant->save();
            // Redirige vers la page publique du restaurant après suppression
            return redirect()->route('restaurants.show', $restaurant->id)->with('success', 'Plat supprimé avec succès !');
        }
        return redirect()->route('restaurants.show', $restaurant->id)->with('error', 'Plat introuvable.');
    }

    /**
     * Corrige tous les plats du menu pour leur attribuer un ID unique si manquant
     */
    public function fixMenuIds($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $menu = $restaurant->menu;
        if (is_string($menu) && !empty($menu)) {
            $menu = json_decode($menu, true);
        }
        if (!is_array($menu)) {
            $menu = [];
        }
        $changed = false;
        foreach ($menu as &$item) {
            if (empty($item['id'])) {
                $item['id'] = uniqid();
                $changed = true;
            }
        }
        if ($changed) {
            $restaurant->menu = $menu;
            $restaurant->save();
        }
        return redirect()->route('restaurateur.restaurant.show', ['id' => $restaurant->id])->with('success', 'Tous les plats sont maintenant commandables !');
    }
}