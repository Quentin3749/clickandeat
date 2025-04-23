<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantBookingController extends Controller
{
    /**
     * Display a listing of restaurants available for booking.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupérer tous les restaurants
        // Si vous avez une colonne accepts_reservations, utilisez le filtre
        // Sinon, récupérez simplement tous les restaurants
        $restaurants = Restaurant::all();
        
        // Si vous avez besoin de filtrer, décommentez cette ligne:
        // $restaurants = Restaurant::where('accepts_reservations', true)->get();
        
        return view('restaurants.book.index', compact('restaurants'));
    }

    /**
     * Show the booking form for a specific restaurant.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showBookingForm(Restaurant $restaurant)
    {
        // Si vous avez un champ accepts_reservations, décommentez ce bloc
        // pour vérifier si le restaurant accepte les réservations
        /*
        if (isset($restaurant->accepts_reservations) && !$restaurant->accepts_reservations) {
            return redirect()->route('restaurants.book')
                ->with('error', 'Ce restaurant n\'accepte pas les réservations.');
        }
        */
        
        return view('restaurants.book.form', compact('restaurant'));
    }

    /**
     * Process the booking request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processBooking(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'date' => 'required|date|after:today',
            'time' => 'required',
            'guests' => 'required|integer|min:1|max:20',
            'notes' => 'nullable|string|max:255',
        ]);

        // Ici, vous pouvez implémenter la logique pour créer une réservation
        // Par exemple:
        /*
        $booking = new \App\Models\Booking();
        $booking->restaurant_id = $restaurant->id;
        $booking->user_id = auth()->id();
        $booking->date = $validated['date'];
        $booking->time = $validated['time'];
        $booking->guests = $validated['guests'];
        $booking->notes = $validated['notes'];
        $booking->status = 'pending';
        $booking->save();
        */

        // Pour l'instant, rediriger avec un message de succès
        return redirect()->route('restaurants.index')
            ->with('success', 'Votre demande de réservation a été envoyée. Nous vous contacterons pour confirmation.');
    }
}