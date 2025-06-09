<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::paginate(20);
        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        // On récupère tous les utilisateurs restaurateurs pour l'association
        $users = \App\Models\User::where('role', 'restaurateur')->get();
        return view('admin.restaurants.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);
        \App\Models\Restaurant::create($request->only('name', 'address', 'user_id'));
        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant créé !');
    }

    public function edit(Restaurant $restaurant)
    {
        return view('admin.restaurants.edit', compact('restaurant'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);
        $restaurant->update($request->only('name', 'address'));
        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant modifié !');
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant supprimé !');
    }
}
