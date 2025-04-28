{{--
    Vue de paiement Stripe
    - Affiche le formulaire de paiement via Stripe
    - Utilise Bootstrap/Tailwind pour la mise en page
    - Explique chaque bloc de formulaire et bouton
--}}
@extends('layouts.app')

@section('content')
<div class="container py-5"> {{-- Conteneur principal Bootstrap --}}
    <h2 class="mb-4">Paiement de la commande #{{ $order->id }}</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>Montant à payer :</strong> {{ number_format($order->total_amount, 2, ',', ' ') }} €</p>
            <form action="{{ route('payment.checkout', $order->id) }}" method="POST" id="payment-form"> {{-- Formulaire Stripe --}}
                @csrf
                <button type="submit" class="btn btn-primary btn-lg mt-3"> {{-- Bouton de soumission --}}
                    Payer avec carte bancaire
                </button>
            </form>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-link">Retour</a>
    </div>
</div>
@endsection
