@extends('layouts.app')

@section('content')
    <div class="dashboard-container" style="min-height:90vh;display:flex;flex-direction:column;justify-content:center;align-items:center;background:linear-gradient(120deg,#fbbf24 0%,#f87171 100%);">
        <div class="dashboard-card animate__animated animate__fadeInDown" style="background:#fffbe9;border-radius:2rem;box-shadow:0 8px 40px rgba(251,191,36,0.10);padding:2.5rem 2rem 2rem 2rem;margin-bottom:2rem;width:100%;max-width:900px;">
            <h2 class="dashboard-title mb-4 text-center" style="font-family:'Poppins',sans-serif;color:#f59e42;font-weight:800;letter-spacing:1px;text-shadow:1px 1px 0 #fff3cd;"><i class="fa fa-clipboard-list me-2"></i>Liste des Commandes</h2>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            {{-- <a href="{{ route('orders.create') }}" class="btn btn-orange mb-3"><i class="fa fa-plus me-1"></i>Créer une Nouvelle Commande</a> --}}
            @if($orders->isNotEmpty())
            <div class="table-responsive mb-5">
            <table class="table align-middle bg-white shadow-sm rounded-4 overflow-hidden">
                <thead class="bg-orange text-white">
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
                            <td class="fw-bold">{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->restaurant->name }}</td>
                            <td>{{ $order->reservation_time ? $order->reservation_time->format('d/m/Y H:i') : 'Immédiate' }}</td>
                            <td>
                                <span class="badge {{ $order->status == 'pending' ? 'bg-warning' : ($order->status == 'processing' ? 'bg-info' : ($order->status == 'ready' ? 'bg-primary' : ($order->status == 'delivered' ? 'bg-success' : ($order->status == 'cancelled' ? 'bg-danger' : 'bg-secondary')))) }}" style="font-size:1em;padding:.6em 1.1em;">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('restaurateur.commandes.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="d-flex align-items-center gap-2">
                                        <select class="form-control form-control-sm rounded-pill" name="status">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>En cours</option>
                                            <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Prête</option>
                                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Livrée</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                                        </select>
                                        <button type="submit" class="btn btn-orange btn-sm rounded-pill px-3">Mettre à Jour</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <div class="d-flex justify-content-center mt-3">{{ $orders->links() }}</div>
            @else
                <p class="text-center text-muted">Aucune commande trouvée.</p>
            @endif

            <h3 class="dashboard-title mb-3 mt-5 text-center" style="font-family:'Poppins',sans-serif;color:#f87171;font-weight:700;letter-spacing:1px;text-shadow:1px 1px 0 #fff3cd;"><i class="fa fa-calendar-check me-2"></i>Liste des Réservations</h3>
            @if($reservations->isNotEmpty())
            <div class="table-responsive">
            <table class="table align-middle bg-white shadow-sm rounded-4 overflow-hidden">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Restaurant</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Nombre de couverts</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                        <tr>
                            <td class="fw-bold">{{ $reservation->id }}</td>
                            <td>{{ $reservation->user->name }}</td>
                            <td>{{ $reservation->restaurant->name }}</td>
                            <td>{{ $reservation->date }}</td>
                            <td>{{ $reservation->time }}</td>
                            <td>{{ $reservation->guests }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <div class="d-flex justify-content-center mt-3">{{ $reservations->links() }}</div>
            @else
                <p class="text-center text-muted">Aucune réservation trouvée.</p>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
.btn-orange { background:#f59e42; border:none; color:#fff; }
.btn-orange:hover { background:#ea580c; color:#fff; }
.bg-orange { background-color:#f59e42!important; color:#fff; font-weight:600; font-size:1rem; }
.table thead th { border:0; }
.table { border-radius:1.5rem; overflow:hidden; }
</style>
@endpush