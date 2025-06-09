@extends('layouts.app')

@push('styles')
<style>
    body.history-page {
        background: linear-gradient(120deg, #fbbf24 0%, #f87171 100%) !important;
        min-height: 100vh !important;
        margin: 0 !important;
        padding: 20px 0 !important;
    }
    
    body.history-page .history-container {
        background: #fffbe9 !important;
        border-radius: 1.5rem !important;
        box-shadow: 0 8px 40px rgba(251,191,36,0.10) !important;
        padding: 2rem !important;
        margin: 2rem auto !important;
        max-width: 1200px !important;
    }
    
    /* Surcharge des styles de base */
    body.history-page .dashboard-container {
        background: transparent !important;
        padding: 0 !important;
        margin: 0 !important;
        max-width: 100% !important;
    }
    .dashboard-container {
        min-height: 90vh;
        padding: 2rem 0;
    }
    .dashboard-card {
        background: #fffbe9;
        border-radius: 1.5rem;
        box-shadow: 0 8px 40px rgba(251,191,36,0.10);
        padding: 2rem;
        margin-bottom: 2rem;
        width: 100%;
        animation: fadeInDown 0.8s;
    }
    .dashboard-title {
        font-family: 'Poppins', sans-serif;
        color: #f59e42;
        font-weight: 800;
        letter-spacing: 1px;
        text-shadow: 1px 1px 0 #fff3cd;
        margin-bottom: 2rem;
    }
    .order-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .order-header {
        background: #f8f9fa;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .order-body {
        padding: 1.5rem;
    }
    .order-footer {
        padding: 1rem 1.5rem;
        background: #f8f9fa;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-pending { background-color: #fef3c7; color: #92400e; }
    .status-processing { background-color: #dbeafe; color: #1e40af; }
    .status-ready { background-color: #d1fae5; color: #065f46; }
    .status-delivered { background-color: #dcfce7; color: #166534; }
    .status-cancelled { background-color: #fee2e2; color: #991b1b; }
    .btn-orange {
        background: #f59e42;
        border: none;
        color: #fff;
        font-weight: 500;
    }
    .btn-orange:hover {
        background: #ea580c;
        color: #fff;
    }
    .item-list {
        list-style: none;
        padding: 0;
        margin: 1rem 0 0 0;
    }
    .item-list li {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px dashed #eee;
    }
    .item-list li:last-child {
        border-bottom: none;
    }
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }
    .empty-state i {
        font-size: 4rem;
        color: #f59e42;
        margin-bottom: 1rem;
        opacity: 0.7;
    }
</style>
@section('content')
<div class="history-page">
    <div class="history-container">
        <h2 class="text-center mb-4">
            <i class="fas fa-history me-2"></i>Historique de vos commandes
        </h2>
        <div class="dashboard-container">
            @if($orders->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Pas encore de commandes</h3>
                    <p class="text-muted">Vous n'avez pas encore passé de commande.</p>
                    <a href="{{ route('restaurants.index') }}" class="btn btn-orange mt-3">
                        <i class="fas fa-utensils me-2"></i>Découvrir les restaurants
                    </a>
                </div>
            @else
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <span class="fw-bold">Commande #{{ $order->id }}</span>
                                <span class="ms-3 text-muted">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $order->created_at->format('d/m/Y à H:i') }}
                                </span>
                            </div>
                            <span class="status-badge status-{{ $order->status }}">
                                @switch($order->status)
                                    @case('pending') En attente @break
                                    @case('processing') En préparation @break
                                    @case('ready') Prête @break
                                    @case('delivered') Livrée @break
                                    @case('cancelled') Annulée @break
                                @endswitch
                            </span>
                        </div>
                        
                        <div class="order-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-1">{{ $order->restaurant ? $order->restaurant->name : 'Restaurant inconnu' }}</h5>
                                    @if($order->reservation_time)
                                        <p class="mb-1 text-muted">
                                            <i class="far fa-clock me-1"></i>
                                            Réservation pour le {{ $order->reservation_time->format('d/m/Y à H:i') }}
                                        </p>
                                    @endif
                                    @if($order->notes)
                                        <p class="mb-0 text-muted">
                                            <i class="far fa-comment-dots me-1"></i>
                                            {{ $order->notes }}
                                        </p>
                                    @endif
                                </div>
                                <div class="text-end">
                                    <div class="h5 mb-0">
                                        {{ number_format($order->items->sum(function($item) { 
                                            return $item->price * $item->pivot->quantity; 
                                        }), 2, ',', ' ') }} €
                                    </div>
                                    <small class="text-muted">{{ $order->items->sum('pivot.quantity') }} article(s)</small>
                                </div>
                            </div>

                            <div class="mt-3">
                                <h6 class="fw-bold mb-2">Détails de la commande :</h6>
                                <ul class="item-list">
                                    @forelse($order->items as $item)
                                        <li>
                                            <span>{{ $item->name ?? 'Article inconnu' }}</span>
                                            <span class="text-muted">{{ $item->pivot->quantity ?? 1 }} × {{ number_format($item->price, 2, ',', ' ') }} €</span>
                                        </li>
                                    @empty
                                        <li class="text-muted">Aucun article trouvé pour cette commande</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                        
                        <div class="order-footer">
                            <div>
                                @if($order->status === 'pending')
                                    <form action="{{ route('orders.cancel', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-times me-1"></i>Annuler
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-orange">
                                    <i class="fas fa-eye me-1"></i>Voir les détails
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
@endsection

@push('scripts')
<script>
    // Scripts spécifiques à la page si nécessaire
</script>
@endpush
