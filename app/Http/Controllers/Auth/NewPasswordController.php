<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

/**
 * Contrôleur pour la création et la réinitialisation d'un nouveau mot de passe.
 */
class NewPasswordController extends Controller
{
    /**
     * Affiche la vue de réinitialisation du mot de passe.
     *
     * Cette méthode est appelée lorsque l'utilisateur demande à réinitialiser son mot de passe.
     * Elle affiche la vue de réinitialisation du mot de passe et passe la requête en paramètre.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Traite la demande de nouveau mot de passe.
     *
     * Cette méthode est appelée lorsque l'utilisateur soumet le formulaire de réinitialisation du mot de passe.
     * Elle valide les champs du formulaire, réinitialise le mot de passe de l'utilisateur et redirige vers la page de connexion.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Valide les champs du formulaire
        // Les champs 'token', 'email' et 'password' sont requis
        // Le champ 'email' doit être un email valide
        // Le champ 'password' doit être confirmé et doit respecter les règles de mot de passe par défaut
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Logique de réinitialisation du mot de passe
        // On utilise la facade Password pour réinitialiser le mot de passe de l'utilisateur
        // On passe les champs 'email', 'password', 'password_confirmation' et 'token' en paramètre
        // On utilise une fonction anonyme pour mettre à jour le mot de passe de l'utilisateur et déclencher l'événement PasswordReset
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                // On met à jour le mot de passe de l'utilisateur
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                // On déclenche l'événement PasswordReset
                event(new PasswordReset($user));
            }
        );

        // Redirige vers la page de connexion avec un message de succès ou d'erreur
        // Si la réinitialisation du mot de passe a réussi, on redirige vers la page de connexion avec un message de succès
        // Sinon, on redirige vers la page précédente avec un message d'erreur
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
