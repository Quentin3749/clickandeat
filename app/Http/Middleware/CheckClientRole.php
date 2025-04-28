<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Middleware qui vérifie si l'utilisateur connecté est un client
class CheckClientRole
{
    /**
     * Intercepte la requête et vérifie le rôle de l'utilisateur.
     * Si l'utilisateur n'est pas client, il est redirigé vers la page de login avec un message d'erreur.
     * Sinon, il peut continuer.
     *
     * @param  Request  $request  La requête HTTP reçue
     * @param  Closure  $next     La prochaine action à exécuter
     * @return Response           La réponse HTTP
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie que l'utilisateur est connecté ET qu'il possède le rôle 'client'
        if (!$request->user() || !$request->user()->isClient()) {
            // Si ce n'est pas un client, on le redirige vers la page de login avec un message d'erreur
            return redirect()->route('login')->with('error', 'Accès réservé aux clients.');
        }

        // Sinon, on laisse passer la requête
        return $next($request);
    }
}
