<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

// Middleware qui supprime les espaces inutiles au début et à la fin des chaînes de caractères dans les requêtes
class TrimStrings extends Middleware
{
    /**
     * Les noms des attributs qui ne doivent PAS être "trimés" (espaces conservés)
     *
     * @var array<int, string>
     */
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
        // Ajouter ici les attributs à exclure du trim
    ];
}
