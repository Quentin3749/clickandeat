{{--
    Vue de succès de paiement
    - Affiche un message de confirmation de paiement réussi
    - Utilise Bootstrap/Tailwind pour la mise en page
    - Explique chaque bloc et bouton
--}}
@extends('layouts.app')

@section('content')
<div class="container py-5 text-center"> {{-- Conteneur principal Bootstrap centré --}}
    <h2 class="mb-4 text-success">✅ Paiement réussi !</h2>
    <div class="card shadow-sm mx-auto" style="max-width: 400px;"> {{-- Bloc de carte Bootstrap --}}
        <div class="card-body">
            <p>Merci pour votre commande #{{ $order->id }}.</p>
            <p><strong>Montant payé :</strong> {{ number_format($order->total_amount, 2, ',', ' ') }} €</p>
            <a href="/" class="btn btn-primary mt-3">Retour à l'accueil</a> {{-- Bouton retour à l'accueil --}}
        </div>
    </div>
</div>
@endsection
