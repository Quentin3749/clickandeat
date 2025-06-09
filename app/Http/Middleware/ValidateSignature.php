<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ValidateSignature as Middleware;

// Middleware qui vérifie la validité des signatures d'URL (liens signés)
class ValidateSignature extends Middleware
{
    /**
     * Les noms des paramètres ignorés lors de la validation de la signature
     *
     * @var array<int, string>
     */
    protected $ignore = [
        // Ajouter ici les paramètres à ignorer
    ];
}
