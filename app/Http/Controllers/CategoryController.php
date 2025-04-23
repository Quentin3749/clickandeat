<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Restaurant;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index', [
            'categories' => Category::with('restaurant')->get(),
        ]);
    }

    public function create()
    {
        return view('categories.create', [
            'restaurants' => Restaurant::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);

        $category = new Category();

        $category->name = $request->input('name');
        $category->restaurant_id = $request->input('restaurant_id');

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Catégorie créée avec succès.');
    }

    public function show($id)
    {
        return view('categories.show', [
            'category' => Category::findOrFail($id),
        ]);
    }

    public function edit($id)
    {
        return view('categories.edit', [
            'category' => Category::findOrFail($id),
            'restaurants' => Restaurant::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);

        $category = Category::findOrFail($id);

        $category->name = $request->input('name');
        $category->restaurant_id = $request->input('restaurant_id');

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Request $request, $id)
    {
        if ($request->input('id') == $id) {
            Category::destroy($id);
            return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès.');
        }

        return redirect()->route('categories.index')->with('error', 'Impossible de supprimer la catégorie.');
    }

    public function showRestaurants($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $restaurant = $category->restaurant;

        return view('categories.restaurants', [
            'category' => $category,
            'restaurant' => $restaurant,
        ]);
    }
}