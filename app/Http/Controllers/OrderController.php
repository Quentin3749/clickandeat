<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use App\Events\OrderStatusUpdated;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('restaurateur')) {
            // Récupérer les IDs des restaurants gérés par le restaurateur
            $restaurantIds = $user->restaurants()->pluck('id');
            // Commandes pour ces restaurants
            $orders = Order::whereIn('restaurant_id', $restaurantIds)
                ->with(['user', 'restaurant'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            // Réservations pour ces restaurants
            $reservations = \App\Models\Reservation::whereIn('restaurant_id', $restaurantIds)
                ->with(['user', 'restaurant'])
                ->orderBy('date', 'desc')
                ->paginate(10);
            return view('restaurateur.commandes', compact('orders', 'reservations'));
        } else {
            // Si l'utilisateur n'est pas un restaurateur, afficher ses propres commandes
            $orders = Order::where('user_id', $user->id)
                ->with(['user', 'restaurant'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return view('orders.index', compact('orders'));
        }
    }

   
    public function create()
    {
        $restaurants = Restaurant::all();
        return view('orders.create', compact('restaurants'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'reservation_time' => 'nullable|date',
            'notes' => 'nullable|string|max:255',
            'items' => 'nullable|array',
            'items.*' => 'nullable|integer|min:0', // Validation pour chaque quantité d'item
        ]);

        $order = auth()->user()->orders()->create([
            'restaurant_id' => $request->restaurant_id,
            'reservation_time' => $request->reservation_time,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        if ($request->has('items')) {
            $items = [];
            foreach ($request->input('items') as $item_id => $quantity) {
                if ($quantity > 0) {
                    $items[$item_id] = ['quantity' => $quantity];
                }
            }
            $order->items()->attach($items);
        }

        return redirect()->route('orders.index')->with('success', 'Commande créée avec succès.');
    }

   
    public function show(Order $order)
    {
        // Vérifier d'abord si la commande existe
        if (!$order) {
            abort(404, 'Commande non trouvée');
        }

        // Charger les relations nécessaires
        $order->load(['items', 'restaurant', 'user']);
        
        // Vérifier si le restaurant existe
        if (!$order->restaurant) {
            // Si le restaurant n'existe pas, on le définit comme null
            // Cela évitera l'erreur dans la vue
            $order->restaurant = null;
        }

        return view('orders.show', compact('order'));
    }

   
    public function edit(Order $order)
    {
        $restaurants = Restaurant::all();
        return view('orders.edit', compact('order', 'restaurants'));
    }

    
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'reservation_time' => 'nullable|date',
            'notes' => 'nullable|string|max:255',
            'status' => 'required|in:pending,processing,ready,delivered,cancelled',
        ]);

        $order->update($request->all());

        return redirect()->route('orders.index')->with('success', 'Commande mise à jour avec succès.');
    }

    
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Commande supprimée avec succès.');
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        // Autoriser uniquement le restaurateur propriétaire à modifier
        if (!auth()->user()->isRestaurateur() || !auth()->user()->restaurants->pluck('id')->contains($order->restaurant_id)) {
            abort(403);
        }
        $validStatuses = ['pending', 'preparing', 'completed', 'cancelled'];
        if (!in_array($request->status, $validStatuses)) {
            return back()->with('error', 'Statut invalide.');
        }
        $order->status = $request->status;
        $order->save();
        // (Optionnel) Envoyer une notification au client ici
        return back()->with('success', 'Statut de la commande mis à jour.');
    }

    /**
     * Affiche l'historique des commandes de l'utilisateur connecté
     */
    public function history()
    {
        $orders = Auth::user()
            ->orders()
            ->with(['restaurant', 'items'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.history', compact('orders'));
    }

    /**
     * Annule une commande
     */
    public function cancel(Order $order)
    {
        // Vérifier que l'utilisateur est propriétaire de la commande
        if ($order->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à annuler cette commande.');
        }

        // Vérifier que la commande peut être annulée
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Cette commande ne peut plus être annulée.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'La commande a été annulée avec succès.');
    }

    /**
     * Génère la facture PDF pour une commande.
     */
    public function invoice($orderId)
    {
        $order = Order::with(['user', 'restaurant', 'items'])->findOrFail($orderId);
        // Optionnel : vérifier que l'utilisateur peut accéder à la commande
        if (Auth::id() !== $order->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }
        $pdf = \PDF::loadView('pdf.invoice', compact('order'));
        return $pdf->download('facture_commande_'.$order->id.'.pdf');
    }
}