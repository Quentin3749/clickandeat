<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

// Middleware qui gère le chiffrement et le déchiffrement automatique des cookies
class EncryptCookies extends Middleware
{
    /**
     * Les noms des cookies qui ne doivent pas être chiffrés.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Ajouter ici les cookies à exclure du chiffrement
    ];
}
