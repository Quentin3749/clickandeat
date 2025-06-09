@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2>Utilisateurs</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Ajouter un utilisateur</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Restaurants associés</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    @foreach($user->restaurants as $restaurant)
                        <span class="badge bg-info">{{ $restaurant->name }}</span>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</button>
                    </form>
                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info">Voir</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection
