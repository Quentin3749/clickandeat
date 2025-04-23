@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des Commandes</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">Créer une Nouvelle Commande</a>

        @if($orders->isNotEmpty())
        <table class="table">
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
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->restaurant->name }}</td>
                <td>{{ $order->reservation_time ? $order->reservation_time->format('d/m/Y H:i') : 'Immédiate' }}</td>
                <td>
                    <span class="badge {{ $order->status == 'pending' ? 'bg-warning' : ($order->status == 'processing' ? 'bg-info' : ($order->status == 'ready' ? 'bg-primary' : ($order->status == 'delivered' ? 'bg-success' : ($order->status == 'cancelled' ? 'bg-danger' : 'bg-secondary')))) }}">
                        {{ $order->status }}
                    </span>
                </td>
                <td>
                    <form action="{{ route('restaurateur.commandes.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="d-flex align-items-center">
                            <select class="form-control form-control-sm" name="status">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>En cours</option>
                                <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Prête</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'bg-success' : '' }}>Livrée</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'bg-danger' : '' }}>Annulée</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm ms-2">Mettre à Jour</button>
                        </div>
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