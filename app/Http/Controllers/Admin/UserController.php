<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Order;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Liste tous les utilisateurs
    public function index()
    {
        $users = User::with('restaurants')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    // Formulaire de création
    public function create()
    {
        return view('admin.users.create');
    }

    // Enregistre un utilisateur
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,restaurateur,client',
            'password' => 'required|string|min:6|confirmed',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé !');
    }

    // Affiche le détail d'un utilisateur
    public function show(User $user)
    {
        $user->load('restaurants');
        return view('admin.users.show', compact('user'));
    }

    // Formulaire d'édition
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Met à jour un utilisateur
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,restaurateur,client',
        ]);
        $user->update($request->only('name', 'email', 'role'));
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
            $user->save();
        }
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur modifié !');
    }

    // Supprime un utilisateur
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé !');
    }

    // Association d'un restaurant à un restaurateur
    public function associateRestaurant(Request $request, User $user)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);
        $user->restaurants()->syncWithoutDetaching([$request->restaurant_id]);
        return back()->with('success', 'Restaurant associé au restaurateur !');
    }

    // Afficher les commandes d'un utilisateur
    public function orders(User $user)
    {
        $orders = Order::where('user_id', $user->id)->with('items')->get();
        return view('admin.users.orders', compact('user', 'orders'));
    }
}
