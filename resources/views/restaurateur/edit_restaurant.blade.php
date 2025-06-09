@extends('layouts.app')

@section('content')
<div class="dashboard-container" style="min-height:90vh;display:flex;flex-direction:column;justify-content:center;align-items:center;background:linear-gradient(120deg,#fbbf24 0%,#f87171 100%);">
    <div class="dashboard-card animate__animated animate__fadeInDown" style="background:#fffbe9;border-radius:2rem;box-shadow:0 8px 40px rgba(251,191,36,0.10);padding:2.5rem 2rem 2rem 2rem;margin-bottom:2rem;width:100%;max-width:600px;">
        <h2 class="dashboard-title mb-4 text-center" style="font-family:'Poppins',sans-serif;color:#f59e42;font-weight:800;letter-spacing:1px;text-shadow:1px 1px 0 #fff3cd;"><i class="fa fa-edit me-2"></i>Modifier le Restaurant</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('restaurateur.restaurant.update', $restaurant->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Nom du restaurant</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $restaurant->name) }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label fw-bold">Description</label>
                <textarea class="form-control" id="description" name="description">{{ old('description', $restaurant->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label fw-bold">Adresse</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $restaurant->address) }}" required>
            </div>
            <div class="mb-3">
                <label for="cuisine_type" class="form-label fw-bold">Type de cuisine</label>
                <input type="text" class="form-control" id="cuisine_type" name="cuisine_type" value="{{ old('cuisine_type', $restaurant->cuisine_type) }}" required>
            </div>
            <div class="mb-3">
                <label for="price_range" class="form-label fw-bold">Tranche de prix</label>
                <input type="text" class="form-control" id="price_range" name="price_range" value="{{ old('price_range', $restaurant->price_range) }}" required>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('restaurateur.restaurant.list') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-orange">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.btn-orange { background:#f59e42; border:none; color:#fff; }
.btn-orange:hover { background:#ea580c; color:#fff; }
.bg-orange { background-color:#f59e42!important; color:#fff; }
</style>
@endpush
