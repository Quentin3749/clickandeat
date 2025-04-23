<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    public function handle(Request $request, Closure $next)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (Auth::check() && $user) {
            if ($user->isAdmin()) {
                return redirect('/admin/dashboard');
            } elseif ($user->isRestaurateur()) {
                return redirect('/restaurateur/dashboard');
            } elseif ($user->isClient()) {
                return redirect('/client/dashboard');
            }
        }

        return $next($request);
    }
}