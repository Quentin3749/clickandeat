<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Restaurant;

class ReservationSimpleController extends Controller
{
    // Liste des réservations de l'utilisateur connecté
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())->with('restaurant')->latest()->get();
        return view('reservations.simple_index', compact('reservations'));
    }

    // Formulaire de réservation
    public function create()
    {
        $restaurants = Restaurant::all();
        return view('reservations.simple_create', compact('restaurants'));
    }

    // Enregistrer une réservation
    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'date' => 'required|date',
            'time' => 'required',
            'people' => 'required|integer|min:1',
        ]);
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'restaurant_id' => $request->restaurant_id,
            'date' => $request->date,
            'time' => $request->time,
            'guests' => $request->people,
        ]);
        return redirect()->route('mes-reservations')->with('success', 'Réservation créée !');
    }

    // Annuler une réservation
    public function cancel($id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $reservation->delete();
        return redirect()->route('mes-reservations')->with('success', 'Réservation annulée.');
    }
}
