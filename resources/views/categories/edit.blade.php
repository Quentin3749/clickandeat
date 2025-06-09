@extends('layout.main')

    @section('main')
        {{-- Vue d'édition de catégorie --}}
        {{-- - Affiche un formulaire pour modifier une catégorie existante --}}
        {{-- - Utilise Bootstrap/Tailwind pour la mise en page --}}
        {{-- - Explique chaque champ et bouton du formulaire --}}
        <h1>Modifier la catégorie : {{ $category->name }}</h1>
        {{-- Formulaire d'édition --}}
        <form action="{{ route('categories.update', $category->id) }}" method="post">
            @csrf
            @method('PUT')
            {{-- Champ nom --}}
            <label for="name">Nom :</label>
            <input type="text" name="name" id="name" value="{{ $category->name }}" required>
            {{-- Champ restaurant --}}
            <label for="restaurant_id">Restaurant :</label>
            <select name="restaurant_id" id="restaurant_id" required>
                @foreach($restaurants as $restaurant)
                    {{-- Option pour chaque restaurant --}}
                    <option value="{{ $restaurant->id }}" {{ $category->restaurant_id == $restaurant->id ? 'selected' : '' }}>{{ $restaurant->name }}</option>
                @endforeach
            </select>
            {{-- Bouton de soumission --}}
            <button type="submit">Modifier</button>
        </form>
    @endsection