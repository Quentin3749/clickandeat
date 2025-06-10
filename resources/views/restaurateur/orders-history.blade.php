@extends('layouts.restaurateur')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-history me-2"></i>Historique des Commandes
                        </h4>
                    </div>
                </div>

                <div class="card-body">
                    @if($orders->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <h3>Aucune commande trouvée</h3>
                            <p class="text-muted">Aucune commande n'a été passée dans vos restaurants pour le moment.</p>
                        </div>
                    @else
                        @foreach($orders as $order)
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Commande #{{ $order->id }}</strong>
                                        <span class="ms-3 text-muted">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            {{ $order->created_at->format('d/m/Y à H:i') }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="badge bg-{{ 
                                            $order->status === 'pending' ? 'warning' : 
                                            ($order->status === 'processing' ? 'info' :
                                            ($order->status === 'delivered' ? 'success' :
                                            ($order->status === 'cancelled' ? 'danger' : 'secondary'))) 
                                        }} me-2">
                                            @switch($order->status)
                                                @case('pending') En attente @break
                                                @case('processing') En préparation @break
                                                @case('delivered') Livrée @break
                                                @case('cancelled') Annulée @break
                                                @default {{ $order->status }}
                                            @endswitch
                                        </span>
                                        <span class="badge bg-primary">
                                            {{ $order->restaurant->name }}
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <h5>Client</h5>
                                            <p class="mb-1">
                                                <i class="fas fa-user me-2"></i>
                                                {{ $order->user->name ?? 'Client inconnu' }}
                                            </p>
                                            @if($order->user->email ?? false)
                                                <p class="mb-0 text-muted">
                                                    <i class="fas fa-envelope me-2"></i>
                                                    {{ $order->user->email }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                            <h5>Montant total</h5>
                                            <h3 class="text-primary">
                                                {{ number_format($order->items->sum(function($item) { 
                                                    return $item->price * $item->pivot->quantity; 
                                                }), 2, ',', ' ') }} €
                                            </h3>
                                        </div>
                                    </div>

                                    <hr>

                                    <h5>Détails de la commande</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Article</th>
                                                    <th class="text-end">Prix unitaire</th>
                                                    <th class="text-center">Quantité</th>
                                                    <th class="text-end">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->items as $item)
                                                    <tr>
                                                        <td>{{ $item->name }}</td>
                                                        <td class="text-end">{{ number_format($item->price, 2, ',', ' ') }} €</td>
                                                        <td class="text-center">{{ $item->pivot->quantity }}</td>
                                                        <td class="text-end">
                                                            {{ number_format($item->price * $item->pivot->quantity, 2, ',', ' ') }} €
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    @if($order->notes)
                                        <div class="mt-3">
                                            <h6>Notes spéciales :</h6>
                                            <p class="mb-0">{{ $order->notes }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-footer d-flex justify-content-between align-items-center">
                                    <div>
                                        @if($order->status === 'pending')
                                            <form action="{{ route('orders.update-status', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="processing">
                                                <button type="submit" class="btn btn-sm btn-success me-2">
                                                    <i class="fas fa-check me-1"></i> Commencer la préparation
                                                </button>
                                            </form>
                                        @elseif($order->status === 'processing')
                                            <form action="{{ route('orders.update-status', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="delivered">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check-circle me-1"></i> Marquer comme livrée
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye me-1"></i> Voir les détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Scripts spécifiques à la page si nécessaire
    document.addEventListener('DOMContentLoaded', function() {
        // Initialisation des tooltips Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
