<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Middleware qui vérifie si l'utilisateur connecté est un administrateur
class CheckIsAdmin
{
    /**
     * Intercepte la requête et vérifie le rôle de l'utilisateur.
     * Si l'utilisateur est admin, il peut continuer. Sinon, il est redirigé.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // Vérifie que l'utilisateur est connecté ET qu'il est admin
        if (Auth::check() && $user && $user->isAdmin()) {
            return $next($request);
        }
        // Sinon, on redirige vers la page d'accueil ou une autre route
        return redirect('/home');
    }
}