<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

/**
 * Contrôleur de gestion des paiements avec Stripe
 *
 * Gère l'affichage de la page de paiement, la création de session Stripe,
 * et les pages de succès/annulation de paiement.
 */
class PaymentController extends Controller
{
    /**
     * Affiche la page de paiement Stripe pour une commande.
     * @param int $orderId
     * @return \Illuminate\View\View
     */
    public function show($orderId)
    {
        // Récupère la commande de l'utilisateur connecté
        $order = Order::where('user_id', Auth::id())->findOrFail($orderId);
        return view('payment.stripe', compact('order'));
    }

    /**
     * Crée une session Stripe Checkout et redirige l'utilisateur.
     * @param \Illuminate\Http\Request $request
     * @param int $orderId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout(Request $request, $orderId)
    {
        // Récupère la commande de l'utilisateur connecté
        $order = Order::where('user_id', Auth::id())->findOrFail($orderId);

        // Initialise la clé secrète Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        // Crée une session Stripe Checkout
        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => (int)($order->total_amount * 100),
                    'product_data' => [
                        'name' => 'Commande #' . $order->id,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', $order->id),
            'cancel_url' => route('payment.cancel', $order->id),
            'customer_email' => Auth::user()->email,
        ]);

        // Redirige l'utilisateur vers la page de paiement Stripe
        return redirect($session->url);
    }

    /**
     * Page de succès Stripe
     * @param int $orderId
     * @return \Illuminate\View\View
     */
    public function success($orderId)
    {
        // Met à jour le statut de la commande comme "payée"
        $order = Order::where('user_id', Auth::id())->findOrFail($orderId);
        $order->status = 'paid';
        $order->save();
        return view('payment.success', compact('order'));
    }

    /**
     * Page d’annulation Stripe
     * @param int $orderId
     * @return \Illuminate\View\View
     */
    public function cancel($orderId)
    {
        // Affiche la page d'annulation de paiement pour la commande
        $order = Order::where('user_id', Auth::id())->findOrFail($orderId);
        return view('payment.cancel', compact('order'));
    }
}
