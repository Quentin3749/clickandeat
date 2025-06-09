{{--
    Vue d'index des commandes
    - Affiche la liste des commandes passées
    - Utilise Bootstrap/Tailwind pour la mise en page
    - Affiche des actions pour voir, éditer ou supprimer une commande
--}}
@extends('layouts.app')

@section('content')
    <div class="container"> {{-- Conteneur principal Bootstrap --}}
        <h1 class="mb-4">Liste des Commandes</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">Créer une Nouvelle Commande</a> {{-- Bouton d'ajout --}}

        @if($orders->isNotEmpty())
            <table class="table table-striped"> {{-- Tableau Bootstrap --}}
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Restaurant</th>
                        <th>Heure de Réservation</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td> {{-- Numéro de commande --}}
                            <td>{{ $order->user->name }}</td> {{-- Client --}}
                            <td>{{ $order->restaurant->name }}</td> {{-- Restaurant --}}
                            <td>{{ $order->reservation_time ? $order->reservation_time->format('d/m/Y H:i') : 'Immédiate' }}</td> {{-- Heure de réservation --}}
                            <td>
                                <span class="badge {{ $order->status == 'pending' ? 'bg-warning' : ($order->status == 'processing' ? 'bg-info' : ($order->status == 'ready' ? 'bg-primary' : ($order->status == 'delivered' ? 'bg-success' : ($order->status == 'cancelled' ? 'bg-danger' : 'bg-secondary')))) }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">Voir</a> {{-- Bouton voir --}}
                                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Modifier</a> {{-- Bouton éditer --}}
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')">Supprimer</button> {{-- Bouton supprimer --}}
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $orders->links() }}
        @else
            <p>Aucune commande trouvée.</p>
        @endif
    </div>
@endsection