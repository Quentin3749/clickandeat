@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2>Modifier l'utilisateur</h2>
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="mb-3">
            <label>Rôle</label>
            <select name="role" class="form-control" required>
                <option value="admin" @if($user->role=='admin') selected @endif>Admin</option>
                <option value="restaurateur" @if($user->role=='restaurateur') selected @endif>Restaurateur</option>
                <option value="client" @if($user->role=='client') selected @endif>Client</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Nouveau mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-warning">Modifier</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
