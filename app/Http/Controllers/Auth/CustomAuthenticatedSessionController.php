<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomAuthenticatedSessionController extends AuthenticatedSessionController
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Récupère l'utilisateur authentifié
        $user = Auth::user();
        
        // Redirige en fonction du rôle
        if ($user->isAdmin()) {
            return redirect('/admin/dashboard');
        }
        
        if ($user->isRestaurateur()) {
            return redirect('/restaurateur/dashboard');
        }
        
        if ($user->isClient()) {
            return redirect('/client/dashboard');
        }
        
        // Redirection par défaut
        return redirect('/dashboard');
    }
}