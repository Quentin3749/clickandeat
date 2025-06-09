<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

// Middleware qui vérifie si l'utilisateur est authentifié (connecté)
class Authenticate extends Middleware
{
    /**
     * Redirige l'utilisateur vers la route 'login' s'il n'est pas authentifié.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo(Request $request): ?string
    {
        // Si la requête n'attend pas de réponse JSON, on redirige vers la page de login
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
