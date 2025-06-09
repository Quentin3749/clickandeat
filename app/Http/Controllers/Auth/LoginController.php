<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Contrôleur d'authentification utilisateur
 *
 * Gère l'affichage du formulaire de connexion, la connexion et la déconnexion.
 * - showLoginForm() : Affiche le formulaire de connexion
 * - login() : Traite la connexion utilisateur
 * - logout() : Déconnecte l'utilisateur
 */
class LoginController extends Controller
{
    /**
     * Affiche la vue du formulaire de connexion
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Traite la connexion de l'utilisateur
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Valide les champs email et mot de passe
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tente d'authentifier l'utilisateur avec les identifiants fournis
        if (Auth::attempt($credentials)) {
            // Régénère la session pour éviter les attaques de fixation de session
            $request->session()->regenerate();

            $user = Auth::user();
            // Redirige selon le rôle de l'utilisateur
            if ($user->role === 'restaurateur') {
                return redirect('/restaurateur/dashboard');
            }
            // Redirection par défaut (client)
            return redirect('/client/dashboard');
        }

        // Retourne à la page précédente avec un message d'erreur si l'authentification échoue
        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    /**
     * Déconnecte l'utilisateur et détruit la session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Définit les middleware pour les méthodes du contrôleur
     * - guest : Autorise uniquement les utilisateurs non connectés pour les méthodes sauf logout
     * - auth : Autorise uniquement les utilisateurs connectés pour la méthode logout
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
