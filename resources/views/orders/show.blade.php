{{--
    Vue de détail d'une commande
    - Affiche les informations détaillées d'une commande
    - Utilise Bootstrap/Tailwind pour la mise en page
    - Explique chaque section et bouton
--}}
@extends('layouts.app')

@section('content')
    <div class="container"> {{-- Conteneur principal Bootstrap --}}
        <h1 class="mb-4">Détails de la Commande #{{ $order->id }}</h1>

        <div class="mb-3">
            <strong>Client:</strong> {{ $order->user->name }} {{-- Client --}}
        </div>

        <div class="mb-3">
            <strong>Restaurant:</strong> {{ $order->restaurant->name }} {{-- Restaurant --}}
        </div>

        <div class="mb-3">
            <strong>Heure de Réservation:</strong> {{ $order->reservation_time ? $order->reservation_time->format('d/m/Y H:i') : 'Immédiate' }} {{-- Date/Heure --}}
        </div>

        <div class="mb-3">
            <strong>Notes Spéciales:</strong>
            <p>{{ $order->notes ?? 'Aucune note.' }}</p> {{-- Notes spéciales --}}
        </div>

        <div class="mb-3">
            <strong>Statut:</strong> {{ $order->status }} {{-- Statut --}}
        </div>

        <h2>Items Commandés</h2>
        @if ($order->items->isNotEmpty())
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->price }} €</td>
                            <td>{{ $item->pivot->quantity }}</td>
                            <td>{{ $item->price * $item->pivot->quantity }} €</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mb-3">
                <strong>Total de la Commande:</strong> {{ $order->items->sum(function ($item) { return $item->price * $item->pivot->quantity; }) }} € {{-- Montant --}}
            </div>
        @else
            <p>Aucun item n'a été commandé.</p>
        @endif

        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Retour à la Liste des Commandes</a> {{-- Bouton retour --}}
        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning">Modifier la Commande</a> {{-- Bouton éditer --}}
    </div>
@endsection