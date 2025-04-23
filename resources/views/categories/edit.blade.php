@extends('layout.main')

    @section('main')
        <h1>Modifier la catégorie : {{ $category->name }}</h1>
        <form action="{{ route('categories.update', $category->id) }}" method="post">
            @csrf
            @method('PUT')
            <label for="name">Nom :</label>
            <input type="text" name="name" id="name" value="{{ $category->name }}" required>
            <label for="restaurant_id">Restaurant :</label>
            <select name="restaurant_id" id="restaurant_id" required>
                @foreach($restaurants as $restaurant)
                    <option value="{{ $restaurant->id }}" {{ $category->restaurant_id == $restaurant->id ? 'selected' : '' }}>{{ $restaurant->name }}</option>
                @endforeach
            </select>
            <button type="submit">Modifier</button>
        </form>
    @endsection