@extends('layout.main')

@section('main')

    <h1>Categories</h1>
    <a href="{{ route('restaurants.index') }}"> liste des restaurants</a>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Restaurant</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->restaurant->name }}</td>
                    <td>
                        <a href="{{ route('categories.show', $category->id) }}">Voir</a>
                        <a href="{{ route('categories.restaurants', $category->id) }}">Voir le restaurant</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection