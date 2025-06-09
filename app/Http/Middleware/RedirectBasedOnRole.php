<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Middleware qui redirige l'utilisateur selon son rôle après connexion
class RedirectBasedOnRole
{
    /**
     * Redirige l'utilisateur vers la page appropriée selon son rôle
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($user) {
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isRestaurateur()) {
                return redirect()->route('restaurateur.dashboard');
            } elseif ($user->isClient()) {
                return redirect()->route('client.dashboard');
            }
        }
        return $next($request);
    }
}