@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2>Modifier le restaurant</h2>
    <form action="{{ route('admin.restaurants.update', $restaurant) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="name" class="form-control" value="{{ $restaurant->name }}" required>
        </div>
        <div class="mb-3">
            <label>Adresse</label>
            <input type="text" name="address" class="form-control" value="{{ $restaurant->address }}" required>
        </div>
        <button type="submit" class="btn btn-warning">Modifier</button>
        <a href="{{ route('admin.restaurants.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
