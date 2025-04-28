@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2>Détail utilisateur</h2>
    <ul>
        <li><strong>Nom :</strong> {{ $user->name }}</li>
        <li><strong>Email :</strong> {{ $user->email }}</li>
        <li><strong>Rôle :</strong> {{ $user->role }}</li>
        <li><strong>Restaurants associés :</strong>
            @foreach($user->restaurants as $restaurant)
                <span class="badge bg-info">{{ $restaurant->name }}</span>
            @endforeach
        </li>
    </ul>
    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Modifier</a>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection
