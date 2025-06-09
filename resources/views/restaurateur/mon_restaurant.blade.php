@extends('layouts.app')

@section('content')
    <div class="dashboard-container" style="min-height:90vh;display:flex;flex-direction:column;justify-content:center;align-items:center;background:linear-gradient(120deg,#fbbf24 0%,#f87171 100%);">
        <div class="dashboard-card animate__animated animate__fadeInDown" style="background:#fffbe9;border-radius:2rem;box-shadow:0 8px 40px rgba(251,191,36,0.10);padding:2.5rem 2rem 2rem 2rem;margin-bottom:2rem;width:100%;max-width:600px;">
            <h2 class="dashboard-title mb-4 text-center" style="font-family:'Poppins',sans-serif;color:#f59e42;font-weight:800;letter-spacing:1px;text-shadow:1px 1px 0 #fff3cd;"><i class="fa fa-store me-2"></i>Mes Restaurants</h2>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($restaurants->isEmpty())
                <div class="alert alert-info text-center">Vous n'avez pas encore de restaurant.<br>
                    <a href="{{ route('restaurateur.restaurant.create') }}" class="btn btn-orange mt-3"><i class="fa fa-plus me-1"></i>Créer un restaurant</a>
                </div>
            @else
                <div class="list-group mb-4">
                    @foreach($restaurants as $restaurant)
                        <div class="list-group-item d-flex justify-content-between align-items-center flex-wrap" style="border-radius:1rem;margin-bottom:10px;background:#fffbe9;border:1px solid #ffe0b2;box-shadow:0 2px 8px rgba(251,191,36,0.07);transition:box-shadow .2s;">
                            <div>
                                <span class="fw-bold" style="color:#f59e42;font-size:1.2rem;">{{ $restaurant->name }}</span><br>
                                <span class="text-muted small"><i class="fa fa-map-marker-alt me-1"></i>{{ $restaurant->address }}</span>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <a href="{{ url('/restaurant/' . $restaurant->id) }}" class="btn btn-outline-primary btn-sm px-3 fw-bold" title="Voir">Voir</a>
                                <a href="{{ route('restaurateur.restaurant.edit', $restaurant->id) }}" class="btn btn-outline-warning btn-sm px-3 fw-bold" title="Modifier">Modifier</a>
                                <a href="{{ url('/restaurateur/mon-restaurant/' . $restaurant->id . '/add-item') }}" class="btn btn-outline-success btn-sm px-3 fw-bold" title="Ajouter un plat">Ajouter un plat</a>
                                <form method="POST" action="{{ route('restaurateur.restaurant.destroy', $restaurant->id) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-bold" title="Supprimer" onclick="return confirm('Supprimer ce restaurant ?')">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('restaurateur.restaurant.create') }}" class="btn btn-orange"><i class="fa fa-plus me-1"></i>Ajouter un restaurant</a>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
.btn-outline-primary { border-color: #2563eb; color: #2563eb; background: #fff; }
.btn-outline-primary:hover { background: #2563eb; color: #fff; }
.btn-outline-warning { border-color: #ffb300; color: #ffb300; background: #fff; }
.btn-outline-warning:hover { background: #ffb300; color: #fff; }
.btn-outline-danger { border-color: #ef4444; color: #ef4444; background: #fff; }
.btn-outline-danger:hover { background: #ef4444; color: #fff; }
.btn-outline-success { border-color: #34c759; color: #34c759; background: #fff; }
.btn-outline-success:hover { background: #34c759; color: #fff; }
</style>
@endpush
