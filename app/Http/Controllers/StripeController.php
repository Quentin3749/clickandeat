<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('client.cart')->with('error', 'Votre panier est vide.');
        }
        $lineItems = [];
        foreach ($cart as $itemId => $qty) {
            $item = \App\Models\Item::find($itemId);
            if ($item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $item->name,
                        ],
                        'unit_amount' => intval($item->price * 100), // en centimes
                    ],
                    'quantity' => $qty,
                ];
            }
        }
        if (empty($lineItems)) {
            return redirect()->route('client.cart')->with('error', 'Aucun article valide dans le panier.');
        }
        Stripe::setApiKey(config('services.stripe.secret'));
        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('client.cart'),
            'customer_email' => Auth::user()->email,
        ]);
        return redirect($session->url);
    }

    public function success(Request $request)
    {
        // Enregistrer la commande après paiement Stripe
        $user = Auth::user();
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('client.cart')->with('error', 'Votre panier est vide.');
        }

        // Création de la commande
        $order = new \App\Models\Order();
        $order->user_id = $user->id;
        $order->status = 'payé';
        $order->total = 0;
        $order->save();

        $total = 0;
        foreach ($cart as $itemId => $qty) {
            $item = \App\Models\Item::find($itemId);
            if ($item) {
                $order->items()->attach($item->id, [
                    'quantity' => $qty,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $total += $item->price * $qty;
            }
        }
        $order->total = $total;
        $order->save();

        session()->forget('cart');
        return view('client.stripe_success');
    }
}
