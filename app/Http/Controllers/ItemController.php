<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category; // Assurez-vous d'importer le modèle Category
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::with('category')->paginate(10); // Récupère tous les items avec pagination et la relation category
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all(); // Récupère toutes les catégories pour le formulaire de création
        return view('items.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
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
        Item::create($request->all());

        // Redirection avec un message de succès
        return redirect()->route('items.index')->with('success', 'Item créé avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $categories = Category::all(); // Récupère toutes les catégories pour le formulaire d'édition
        return view('items.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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