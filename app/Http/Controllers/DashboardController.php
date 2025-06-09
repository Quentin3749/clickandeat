<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Reservation;

/**
 * Contrôleur du tableau de bord utilisateur
 *
 * Affiche les informations principales pour l'utilisateur connecté (commandes, réservations, etc.).
 */
class DashboardController extends Controller
{
    /**
     * Affiche la page du tableau de bord en fonction du rôle de l'utilisateur.
     * 
     * Cette méthode vérifie le rôle de l'utilisateur connecté et affiche la vue correspondante.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupère l'utilisateur connecté
        $user = Auth::user(); // Récupérer l'utilisateur actuellement authentifié

        // Récupère les commandes récentes de l'utilisateur
        $orders = Order::where('user_id', $user->id)->latest()->take(5)->get();

        // Récupère les réservations récentes de l'utilisateur
        $reservations = Reservation::where('user_id', $user->id)->latest()->take(5)->get();

        // Vérification du rôle de l'utilisateur
        if ($user->isAdmin()) {
            // Si l'utilisateur est un admin, afficher la vue pour l'admin
            // avec les données des commandes et réservations récentes
            return view('dashboard.admin', compact('user', 'orders', 'reservations')); 
        } elseif ($user->isRestaurateur()) {
            // Si l'utilisateur est un restaurateur, afficher la vue pour le restaurateur
            // avec les données des commandes et réservations récentes
            return view('dashboard.restaurateur', compact('user', 'orders', 'reservations'));
        } elseif ($user->isClient()) {
            // Si l'utilisateur est un client, afficher la vue pour le client
            // avec les données des commandes et réservations récentes
            return view('client.dashboard', compact('user', 'orders', 'reservations'));
        }

        // Si aucun rôle ne correspond, rediriger ou afficher une page d'erreur
        return redirect('/')->with('error', 'Accès interdit');
    }
}
