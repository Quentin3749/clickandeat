<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Vérifier si l'utilisateur est authentifié et a le bon rôle
        if (!Auth::check() || !Auth::user()->{"is" . ucfirst($role)}()) {
            // Rediriger si l'utilisateur n'a pas le rôle nécessaire
            return redirect('/dashboard');  // Ou toute autre page de redirection
        }

        return $next($request);
    }
}
