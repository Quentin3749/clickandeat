<?php

use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Paiement Stripe', function () {
    it('redirige un client connecté vers Stripe Checkout', function () {
        $user = User::factory()->create(['role' => 'client']);
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'total_amount' => 25.50,
            'status' => 'pending',
        ]);
        $this->actingAs($user)
            ->post(route('payment.checkout', $order->id))
            ->assertRedirect(); // Stripe Checkout redirige
    });

    it('refuse l\'accès à la page de paiement si non connecté', function () {
        $order = Order::factory()->create();
        $this->get(route('payment.show', $order->id))
            ->assertRedirect('/login');
    });
});
