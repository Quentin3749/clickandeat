@extends('layouts.app')

@section('content')
<div class="dashboard-container" style="min-height:90vh;display:flex;flex-direction:column;justify-content:center;align-items:center;background:linear-gradient(120deg,#fbbf24 0%,#f87171 100%);">
    <div class="dashboard-card animate__animated animate__fadeInDown" style="background:#fffbe9;border-radius:2rem;box-shadow:0 8px 40px rgba(251,191,36,0.10);padding:2.5rem 2rem 2rem 2rem;margin-bottom:2rem;width:100%;max-width:600px;">
        <div class="text-center mb-4">
            <img src="{{ $restaurant->image_url ?? asset('img/restaurant-default.jpg') }}" alt="Image du restaurant" style="width:110px;height:110px;object-fit:cover;border-radius:50%;box-shadow:0 4px 16px rgba(0,0,0,0.10);border:4px solid #fffbe9;background:#ffe0b2;">
        </div>
        <h2 class="fw-bold text-center mb-2" style="color:#f59e42;font-size:2rem;">{{ $restaurant->name }}</h2>
        <div class="mb-3 text-center" style="color:#ea580c;font-size:1.1rem;">
            <i class="fa fa-map-marker-alt me-1"></i>{{ $restaurant->address }}
        </div>
        <div class="mb-3 text-center">
            <span class="badge bg-orange me-1">{{ $restaurant->cuisine_type }}</span>
            <span class="badge bg-orange">{{ $restaurant->price_range }}</span>
        </div>
        <div class="mb-4 text-center text-muted" style="font-size:1.1rem;">
            {{ $restaurant->description ?? 'Aucune description fournie.' }}
        </div>
        <div class="d-flex justify-content-center gap-2 mt-3">
            <a href="{{ route('restaurateur.restaurant.edit', $restaurant->id) }}" class="btn btn-outline-warning fw-bold">Modifier</a>
            <form method="POST" action="{{ route('restaurateur.restaurant.destroy', $restaurant->id) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger fw-bold" onclick="return confirm('Supprimer ce restaurant ?')">Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bg-orange { background-color:#f59e42!important; color:#fff; font-weight:600; font-size:1rem; }
.btn-outline-warning { border-color: #ffb300; color: #ffb300; background: #fff; }
.btn-outline-warning:hover { background: #ffb300; color: #fff; }
.btn-outline-danger { border-color: #ef4444; color: #ef4444; background: #fff; }
.btn-outline-danger:hover { background: #ef4444; color: #fff; }
</style>
@endpush
