<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category; // Assurez-vous d'importer le modèle Category
use Illuminate\Http\Request;

/**
 * Contrôleur de gestion des plats (items)
 *
 * Permet de lister, créer, afficher, modifier et supprimer des plats.
 */
class ItemController extends Controller
{
    /**
     * Affiche la liste des plats.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupère tous les plats avec pagination et la relation category
        $items = Item::with('category')->paginate(10);
        return view('items.index', compact('items'));
    }

    /**
     * Affiche le formulaire de création d'un plat.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Récupère toutes les catégories pour le formulaire de création
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    /**
     * Enregistre un nouveau plat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'name' => 'required|max:255',
            'cost' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id', // Vérifie que la catégorie existe
            'is_active' => 'nullable|boolean',
        ]);

        // Création d'un nouvel item
        $data = $request->all();
        // Associer le plat au restaurant du restaurateur connecté
        $user = auth()->user();
        if ($user->hasRole('restaurateur')) {
            // Si l'utilisateur a plusieurs restaurants, il faut choisir ou passer via le formulaire
            // Ici, on prend le premier restaurant trouvé
            $restaurant = $user->restaurants()->first();
            if ($restaurant) {
                $data['restaurant_id'] = $restaurant->id;
            }
        }
        Item::create($data);

        // Redirection avec un message de succès
        return redirect()->route('items.index')->with('success', 'Item créé avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d'un plat.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        // Récupère toutes les catégories pour le formulaire d'édition
        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    /**
     * Met à jour un plat existant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        // Validation des données du formulaire
        $request->validate([
            'name' => 'required|max:255',
            'cost' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id', // Vérifie que la catégorie existe
            'is_active' => 'nullable|boolean',
        ]);

        // Mise à jour de l'item
        $item->update($request->all());

        // Redirection avec un message de succès
        return redirect()->route('items.index')->with('success', 'Item mis à jour avec succès.');
    }

    /**
     * Supprime un plat.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();

        // Redirection avec un message de succès
        return redirect()->route('items.index')->with('success', 'Item supprimé avec succès.');
    }
}