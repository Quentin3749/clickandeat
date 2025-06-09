<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

// Middleware qui bloque l'accès à l'application pendant la maintenance
class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * Les URI qui doivent être accessibles même pendant la maintenance.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Ajouter ici les URI à exclure du blocage
    ];
}
