@extends('layouts.app')

@section('content')
    <div class="dashboard-container" style="min-height:90vh;display:flex;flex-direction:column;justify-content:center;align-items:center;background:linear-gradient(120deg,#fbbf24 0%,#f87171 100%);">
        <div class="dashboard-card animate__animated animate__fadeInDown" style="background:#fffbe9;border-radius:2rem;box-shadow:0 8px 40px rgba(251,191,36,0.10);padding:2.5rem 2rem 2rem 2rem;margin-bottom:2rem;width:100%;max-width:600px;">
            <h2 class="dashboard-title mb-4 text-center" style="font-family:'Poppins',sans-serif;color:#f59e42;font-weight:800;letter-spacing:1px;text-shadow:1px 1px 0 #fff3cd;"><i class="fa fa-utensils me-2"></i>Ajouter un plat à <b>{{ $restaurant->name }}</b></h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('restaurateur.restaurant.storeitem', $restaurant->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Nom du plat</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label fw-bold">Prix (€)</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label fw-bold">Catégorie</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <option value="">Sélectionnez une catégorie</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label fw-bold">Image (optionnelle)</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <button type="submit" class="btn btn-orange fw-bold px-4">Ajouter le plat</button>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary fw-bold px-4">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<style>
.btn-orange { background: #f59e42; color: #fff; border: none; }
.btn-orange:hover { background: #fbbf24; color: #fff; }
.dashboard-title { font-size: 2rem; }
</style>
@endpush
