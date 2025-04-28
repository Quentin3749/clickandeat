<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

// Middleware qui protège l'application contre les attaques CSRF (Cross-Site Request Forgery)
class VerifyCsrfToken extends Middleware
{
    /**
     * Les URI qui doivent être exclues de la vérification CSRF.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Ajouter ici les URI à exclure de la protection CSRF
    ];
}
