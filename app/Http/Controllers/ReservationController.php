<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Contrôleur de gestion des réservations
 *
 * Permet à l'utilisateur de lister, créer et annuler ses réservations dans un restaurant.
 */
class ReservationController extends Controller
{
    /**
     * Affiche la liste des réservations de l'utilisateur connecté.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupère les réservations de l'utilisateur avec le restaurant associé
        $reservations = Auth::user()->reservations()->with('restaurant')->orderBy('date', 'desc')->get();
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Affiche le formulaire de réservation pour un restaurant.
     * @param \App\Models\Restaurant $restaurant
     * @return \Illuminate\View\View
     */
    public function create(Restaurant $restaurant)
    {
        // Affiche le formulaire de réservation pour le restaurant sélectionné
        return view('reservations.create', compact('restaurant'));
    }

    /**
     * Enregistre une nouvelle réservation.
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Restaurant $restaurant
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Restaurant $restaurant)
    {
        // Valide les champs du formulaire
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'guests' => 'required|integer|min:1|max:20',
            'notes' => 'nullable|string|max:255',
        ]);

        // Vérifie que l'heure demandée est dans la plage d'ouverture du restaurant
        $opening = $restaurant->opening_time ?? '11:00:00';
        $closing = $restaurant->closing_time ?? '23:00:00';
        if ($request->time < $opening || $request->time > $closing) {
            return back()->withErrors(['time' => "Ce restaurant n'est pas ouvert à cette heure."])->withInput();
        }

        // Crée la réservation
        Reservation::create([
            'restaurant_id' => $restaurant->id,
            'user_id' => Auth::id(),
            'date' => $request->date,
            'time' => $request->time,
            'guests' => $request->guests,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        // Redirige vers la liste des réservations avec un message de succès
        return redirect()->route('reservations.index')->with('success', 'Réservation enregistrée !');
    }

    /**
     * Annule une réservation existante.
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Reservation $reservation)
    {
        // Vérifie que la réservation appartient à l'utilisateur connecté
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }
        // Met à jour le statut de la réservation
        $reservation->status = 'cancelled';
        $reservation->save();
        return redirect()->route('reservations.index')->with('success', 'Réservation annulée.');
    }
}
