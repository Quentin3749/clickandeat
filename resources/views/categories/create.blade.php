@extends('layout.main')

    @section('main')
        <h1>Créer une catégorie</h1>
        <form action="{{ route('categories.store') }}" method="post">
            @csrf
            <label for="name">Nom :</label>
            <input type="text" name="name" id="name" required>
            <label for="restaurant_id">Restaurant :</label>
            <select name="restaurant_id" id="restaurant_id" required>
                @foreach($restaurants as $restaurant)
                    <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                @endforeach
            </select>
            <button type="submit">Créer</button>
        </form>
    @endsection