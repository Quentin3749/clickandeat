<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Contrôleur de gestion du profil utilisateur
 *
 * Permet d'afficher, de mettre à jour et de supprimer le profil de l'utilisateur connecté.
 */
class ProfileController extends Controller
{
    /**
     * Affiche la page du profil utilisateur.
     *
     * Cette méthode affiche la vue du profil utilisateur avec les informations de l'utilisateur connecté.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request): View
    {
        // Affiche la vue avec les informations de l'utilisateur connecté
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Met à jour le profil utilisateur.
     *
     * Cette méthode met à jour les informations de l'utilisateur en fonction des données validées.
     * Si l'e-mail a changé, la vérification de l'e-mail est réinitialisée.
     *
     * @param \App\Http\Requests\ProfileUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Valide et met à jour les informations de l'utilisateur
        $request->user()->fill($request->validated());

        // Réinitialise la vérification de l'e-mail si l'e-mail a changé
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Enregistre les modifications
        $request->user()->save();

        // Redirige vers la page du profil avec un message de succès
        return Redirect::route('profile.edit')->with('status', 'Profil mis à jour !');
    }

    /**
     * Supprime le compte utilisateur.
     *
     * Cette méthode supprime l'utilisateur connecté après avoir validé son mot de passe.
     * La session est également invalidée et un nouveau token de session est généré.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Valide le mot de passe de l'utilisateur
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Récupère l'utilisateur connecté
        $user = $request->user();

        // Déconnecte l'utilisateur
        Auth::logout();

        // Supprime l'utilisateur
        $user->delete();

        // Invalide la session et génère un nouveau token de session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirige vers la page d'accueil avec un message de succès
        return Redirect::to('/')->with('success', 'Compte supprimé avec succès.');
    }
}
