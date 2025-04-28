{{--
    Vue d'édition d'une commande
    - Affiche un formulaire pour modifier une commande existante
    - Utilise Bootstrap/Tailwind pour la mise en page
    - Explique chaque champ et bouton du formulaire
--}}
@extends('layouts.app')

@section('content')
    <div class="container"> {{-- Conteneur principal Bootstrap --}}
        <h1 class="mb-4">Modifier la Commande #{{ $order->id }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('orders.update', $order->id) }}" method="POST"> {{-- Formulaire d'édition --}}
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="restaurant_id" class="form-label">Restaurant</label>
                <select class="form-control" id="restaurant_id" name="restaurant_id" required>
                    <option value="">Sélectionnez un restaurant</option>
                    @foreach($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}" {{ $order->restaurant_id == $restaurant->id ? 'selected' : '' }}>
                            {{ $restaurant->name }}
                        </option>
                    @endforeach
                </select> {{-- Champ restaurant --}}
            </div>

            <div class="mb-3">
                <label for="reservation_time" class="form-label">Heure de Réservation (Optionnel)</label>
                <input type="datetime-local" class="form-control" id="reservation_time" name="reservation_time" value="{{ $order->reservation_time ? $order->reservation_time->format('Y-m-d\TH:i') : '' }}"> {{-- Champ date/heure --}}
                <small class="form-text text-muted">Laissez vide si la commande est immédiate.</small>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes Spéciales (Optionnel)</label>
                <textarea class="form-control" id="notes" name="notes" rows="3">{{ $order->notes }}</textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Statut</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>En cours</option>
                    <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Prête</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Livrée</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à Jour la Commande</button> {{-- Bouton de soumission --}}
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection