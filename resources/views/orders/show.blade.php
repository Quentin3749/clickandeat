@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Détails de la Commande #{{ $order->id }}</h1>

        <div class="mb-3">
            <strong>Client:</strong> {{ $order->user->name }}
        </div>

        <div class="mb-3">
            <strong>Restaurant:</strong> {{ $order->restaurant->name }}
        </div>

        <div class="mb-3">
            <strong>Heure de Réservation:</strong> {{ $order->reservation_time ? $order->reservation_time->format('d/m/Y H:i') : 'Immédiate' }}
        </div>

        <div class="mb-3">
            <strong>Notes Spéciales:</strong>
            <p>{{ $order->notes ?? 'Aucune note.' }}</p>
        </div>

        <div class="mb-3">
            <strong>Statut:</strong> {{ $order->status }}
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
                <strong>Total de la Commande:</strong> {{ $order->items->sum(function ($item) { return $item->price * $item->pivot->quantity; }) }} €
            </div>
        @else
            <p>Aucun item n'a été commandé.</p>
        @endif

        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Retour à la Liste des Commandes</a>
        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning">Modifier la Commande</a>
    </div>
@endsection