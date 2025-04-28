<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

// Middleware qui redirige les utilisateurs authentifiés vers leur page d'accueil
class RedirectIfAuthenticated
{
    /**
     * Gère la redirection si l'utilisateur est déjà authentifié
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Si aucun guard n'est spécifié, on utilise le guard par défaut
        $guards = empty($guards) ? [null] : $guards;

        // On vérifie pour chaque guard si l'utilisateur est authentifié
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Si l'utilisateur est authentifié, on récupère son objet utilisateur
                $user = Auth::user();
                
                // On redirige l'utilisateur vers sa page d'accueil en fonction de son rôle
                if ($user->role === 'restaurateur') {
                    return redirect()->route('restaurateur.dashboard');
                } elseif ($user->role === 'client') {
                    return redirect()->route('client.dashboard');
                }
                
                // Si l'utilisateur n'a pas de rôle spécifique, on le redirige vers la page d'accueil par défaut
                return redirect(RouteServiceProvider::HOME);
            }
        }

        // Si l'utilisateur n'est pas authentifié, on poursuit la requête
        return $next($request);
    }
}
