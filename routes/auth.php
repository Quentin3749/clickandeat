<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// ---------------------------------------------
// Fichier de routes d'authentification Laravel
// Définit toutes les routes liées à l'inscription, connexion, vérification email, etc.
// ---------------------------------------------

// Routes pour les utilisateurs non connectés
Route::middleware('guest')->group(function () {
    // Inscription
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    // Connexion
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    // Route de connexion modifiée pour rediriger en fonction du role
    Route::post('login', function (Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::user();

            if ($user->isAdmin()) {
                return redirect('/admin/dashboard');
            }

            if ($user->isRestaurateur()) {
                return redirect('/restaurateur/dashboard');
            }

            if ($user->isClient()) {
                return redirect('/client/dashboard');
            }

            return redirect('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    })->name('post.login'); // <-- ROUTE POST RENOMMÉE

    // Réinitialisation du mot de passe
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

// Routes pour les utilisateurs connectés
Route::middleware('auth')->group(function () {
    // Vérification d'email
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    // Confirmation du mot de passe
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Déconnexion
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});

// Correction automatique : remplacement de 'rôle' par 'role' dans tous les middlewares de ce fichier
// (aucune occurrence trouvée dans la recherche, mais correction défensive)

// Routes protégées par les middlewares de role
Route::middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    // Ajoutez ici d'autres routes spécifiques aux administrateurs
});

Route::middleware(['auth', 'check.restaurateur'])->group(function () {
    Route::get('/restaurateur/dashboard', function () {
        return view('restaurateur.dashboard');
    });

    // Ajoutez ici d'autres routes spécifiques aux restaurateurs
});

Route::middleware(['auth', 'check.client'])->group(function () {
    Route::get('/client/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);
    // Ajoutez ici d'autres routes spécifiques aux clients
});