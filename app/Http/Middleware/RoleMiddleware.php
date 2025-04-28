<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

// Middleware générique pour vérifier le rôle d'un utilisateur
class RoleMiddleware
{
    /**
     * Vérifie si l'utilisateur possède un rôle spécifique
     * @param Request $request
     * @param Closure $next
     * @param string $role Le rôle attendu
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        Log::info('RoleMiddleware appelé avec le rôle : ' . $role);
        // Vérifier si l'utilisateur est authentifié et a le bon rôle
        if (!Auth::check() || !Auth::user()->{"is" . ucfirst($role)}()) {
            // Rediriger si l'utilisateur n'a pas le rôle nécessaire
            return redirect('/dashboard');  // Ou toute autre page de redirection
        }

        return $next($request);
    }
}
