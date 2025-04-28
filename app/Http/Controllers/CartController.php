<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewOrderNotification;

class CartController extends Controller
{
    // Affiche le panier du client
    public function show(Request $request)
    {
        $cart = session('cart', []);
        return view('cart.show', compact('cart'));
    }

    // Ajoute un item au panier
    public function add(Request $request, $itemId)
    {
        $item = Item::findOrFail($itemId);
        $cart = session('cart', []);
        $cart[$itemId] = ($cart[$itemId] ?? 0) + 1;
        session(['cart' => $cart]);
        return back()->with('success', 'Plat ajouté au panier !');
    }

    // Retire un item du panier
    public function remove(Request $request, $itemId)
    {
        $cart = session('cart', []);
        unset($cart[$itemId]);
        session(['cart' => $cart]);
        return back()->with('success', 'Plat retiré du panier.');
    }

    // Valide et paie la commande (Stripe sera intégré ici)
    public function checkout(Request $request, $restaurantId)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Votre panier est vide.');
        }
        $restaurant = Restaurant::findOrFail($restaurantId);
        $items = Item::whereIn('id', array_keys($cart))->get();
        $total = 0;
        foreach ($items as $item) {
            $total += $item->price * $cart[$item->id];
        }
        // Création de la commande
        $order = Order::create([
            'user_id' => Auth::id(),
            'restaurant_id' => $restaurant->id,
            'status' => 'pending',
            'total' => $total,
        ]);
        // Lier les items à la commande
        foreach ($cart as $itemId => $qty) {
            $order->items()->attach($itemId, ['quantity' => $qty]);
        }
        // Notification au restaurateur
        Notification::route('mail', $restaurant->user->email)
            ->notify(new NewOrderNotification($order));
        // Vider le panier
        session()->forget('cart');
        // Rediriger vers le paiement Stripe
        return redirect()->route('payment.show', $order->id);
    }
}
