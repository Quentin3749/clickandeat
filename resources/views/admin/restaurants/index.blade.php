@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2>Restaurants</h2>
    <a href="{{ route('admin.restaurants.create') }}" class="btn btn-primary mb-3">Ajouter un restaurant</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($restaurants as $restaurant)
            <tr>
                <td>{{ $restaurant->name }}</td>
                <td>{{ $restaurant->address }}</td>
                <td>
                    <a href="{{ route('admin.restaurants.edit', $restaurant) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('admin.restaurants.destroy', $restaurant) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce restaurant ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $restaurants->links() }}
</div>
@endsection
