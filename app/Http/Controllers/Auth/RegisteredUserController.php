<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

/**
 * Contrôleur d'inscription utilisateur
 *
 * Gère l'affichage du formulaire d'inscription et l'enregistrement d'un nouvel utilisateur.
 * - create() : Affiche le formulaire d'inscription
 * - store() : Traite et enregistre l'inscription
 */
class RegisteredUserController extends Controller
{
    /**
     * Affiche la vue du formulaire d'inscription
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Traite l'inscription d'un nouvel utilisateur
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valide les champs du formulaire d'inscription
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:client,restaurateur'],
        ]);

        // Crée un nouvel utilisateur avec les données validées
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash le mot de passe
            'role' => $request->role,
        ]);

        // Déclenche l'événement Registered (pour l'email de bienvenue, etc.)
        event(new Registered($user));

        // Connecte automatiquement l'utilisateur après l'inscription
        Auth::login($user);

        // Redirige selon le rôle sélectionné
        if ($request->role === 'restaurateur') {
            return redirect('/restaurateur/dashboard');
        }

        // Redirection par défaut (client)
        return redirect('/client/dashboard');
    }
}
