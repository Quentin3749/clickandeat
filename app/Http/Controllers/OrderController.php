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
            // Récupérer les commandes pour ces restaurants
            $orders = Order::whereIn('restaurant_id', $restaurantIds)
                ->with(['user', 'restaurant'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return view('restaurateur.commandes.index', compact('orders'));
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
        $order->load('items'); // Charger la relation 'items'
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
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,ready,delivered,cancelled',
        ]);

      
        
        if (!Auth::user()->restaurants->pluck('id')->contains($order->restaurant_id)) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette commande.');
        }

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        Event::dispatch(new OrderStatusUpdated($order, $oldStatus));

        return back()->with('success', 'Statut de la commande mis à jour avec succès.');
    }
}