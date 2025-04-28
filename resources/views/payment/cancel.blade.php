{{--
    Vue d'annulation de paiement
    - Affiche un message d'annulation ou d'échec du paiement
    - Utilise Bootstrap/Tailwind pour la mise en page
    - Explique chaque bloc et bouton
--}}
@extends('layouts.app')

@section('content')
<div class="container py-5 text-center"> {{-- Conteneur principal Bootstrap centré --}}
    <h2 class="mb-4 text-danger">❌ Paiement annulé</h2>
    <div class="card shadow-sm mx-auto" style="max-width: 400px;"> {{-- Bloc de carte Bootstrap --}}
        <div class="card-body">
            <p>Votre paiement pour la commande #{{ $order->id }} a été annulé.</p>
            <a href="{{ route('payment.show', $order->id) }}" class="btn btn-warning mt-3">Réessayer le paiement</a> {{-- Bouton réessayer --}}
            <a href="/" class="btn btn-link mt-3">Retour à l'accueil</a> {{-- Bouton retour --}}
        </div>
    </div>
</div>
@endsection
