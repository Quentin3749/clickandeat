<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Ce middleware vérifie si l'utilisateur connecté possède le rôle 'restaurateur'.
// Si oui, il laisse passer la requête. Sinon, il redirige vers la page d'accueil.
class CheckIsRestaurateur
{
    /**
     * Traite la requête entrante.
     * @param Request $request La requête HTTP reçue
     * @param Closure $next La prochaine action à exécuter
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifie que l'utilisateur est connecté ET qu'il est restaurateur
        if (auth()->check() && auth()->user()->isRestaurateur()) {
            // Si oui, on laisse passer la requête vers la suite de l'application
            return $next($request);
        }

        // Sinon, on redirige l'utilisateur vers la page d'accueil
        return redirect('/home'); // Ou toute autre redirection
    }
}