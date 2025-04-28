@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Historique de vos commandes</h2>

    @if($orders->isEmpty())
        <div class="alert alert-info">
            Vous n'avez pas encore passé de commande.
        </div>
    @else
        <div class="row">
            @foreach($orders as $order)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Commande #{{ $order->id }}</span>
                            <span class="badge {{ $order->status === 'delivered' ? 'bg-success' : ($order->status === 'cancelled' ? 'bg-danger' : 'bg-primary') }}">
                                @switch($order->status)
                                    @case('pending')
                                        En attente
                                        @break
                                    @case('processing')
                                        En préparation
                                        @break
                                    @case('ready')
                                        Prête
                                        @break
                                    @case('delivered')
                                        Livrée
                                        @break
                                    @case('cancelled')
                                        Annulée
                                        @break
                                @endswitch
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $order->restaurant->name }}</h5>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-calendar"></i> 
                                    Commandé le {{ $order->created_at->format('d/m/Y à H:i') }}
                                </small>
                            </p>
                            @if($order->reservation_time)
                                <p class="card-text">
                                    <i class="fas fa-clock"></i> 
                                    Réservation pour le {{ $order->reservation_time->format('d/m/Y à H:i') }}
                                </p>
                            @endif
                            @if($order->notes)
                                <p class="card-text">
                                    <i class="fas fa-comment"></i> 
                                    Notes: {{ $order->notes }}
                                </p>
                            @endif
                            <div class="mt-3">
                                <h6>Articles commandés :</h6>
                                <ul class="list-group">
                                    @foreach($order->items as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $item->name }}
                                            <span class="badge bg-primary rounded-pill">{{ $item->pivot->quantity }}x</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="card-footer">
                            @if($order->status === 'pending')
                                <form action="{{ route('orders.cancel', $order) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-times"></i> Annuler
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> Détails
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush
