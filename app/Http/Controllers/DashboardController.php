<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Affiche la page du dashboard en fonction du rôle de l'utilisateur.
     */
    public function index()
    {
        $user = Auth::user(); // Récupérer l'utilisateur actuellement authentifié

        // Vérification du rôle de l'utilisateur
        if ($user->isAdmin()) {
            // Si l'utilisateur est un admin, afficher la vue pour l'admin
            return view('dashboard.admin'); 
        } elseif ($user->isRestaurateur()) {
            // Si l'utilisateur est un restaurateur, afficher la vue pour le restaurateur
            return view('dashboard.restaurateur');
        } elseif ($user->isClient()) {
            // Si l'utilisateur est un client, afficher la vue pour le client
            return view('dashboard.client');
        }

        // Si aucun rôle ne correspond, rediriger ou afficher une page d'erreur
        return redirect('/')->with('error', 'Accès interdit');
    }
}


