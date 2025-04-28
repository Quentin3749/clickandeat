@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2>Ajouter un utilisateur</h2>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Rôle</label>
            <select name="role" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="restaurateur">Restaurateur</option>
                <option value="client">Client</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Confirmation mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Créer</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
