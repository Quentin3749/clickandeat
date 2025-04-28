@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2>Ajouter un restaurant</h2>
    <form action="{{ route('admin.restaurants.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Adresse</label>
            <input type="text" name="address" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Utilisateur associé (restaurateur)</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Sélectionner un utilisateur --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Créer</button>
        <a href="{{ route('admin.restaurants.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
