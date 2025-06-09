<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Middleware qui vérifie si l'utilisateur connecté a le rôle restaurateur
class CheckRestaurateurRole
{
    /**
     * Intercepte la requête et vérifie le rôle de l'utilisateur.
     * Si l'utilisateur est restaurateur, il peut continuer. Sinon, il est redirigé.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie que l'utilisateur est connecté ET qu'il est restaurateur
        if (!$request->user() || !$request->user()->isRestaurateur()) {
            // Sinon, on redirige vers la page de connexion avec un message d'erreur
            return redirect()->route('login')->with('error', 'Accès réservé aux restaurateurs.');
        }
        // Sinon, on laisse passer la requête
        return $next($request);
    }
}
