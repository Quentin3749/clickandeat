<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIsRestaurateur
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isRestaurateur()) {
            return $next($request);
        }

        return redirect('/home'); // Ou toute autre redirection
    }
}