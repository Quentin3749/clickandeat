{{--
    Vue de création de catégorie
    - Affiche un formulaire pour ajouter une nouvelle catégorie
    - Utilise Bootstrap/Tailwind pour la mise en page
    - Explique chaque champ et bouton du formulaire
--}}
@extends('layout.main')

@section('main')
    <div class="container"> {{-- Conteneur principal Bootstrap --}}
        <h1 class="mb-4">Créer une catégorie</h1>
        <form action="{{ route('categories.store') }}" method="post"> {{-- Formulaire de création --}}
            @csrf
            <div class="form-group mb-3">
                <label for="name">Nom</label>
                <input type="text" name="name" id="name" class="form-control" required> {{-- Champ nom --}}
            </div>
            <div class="form-group mb-3">
                <label for="restaurant_id">Restaurant :</label>
                <select name="restaurant_id" id="restaurant_id" class="form-control" required>
                    @foreach($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                    @endforeach
                </select> {{-- Champ restaurant --}}
            </div>
            <button type="submit" class="btn btn-success">Créer</button> {{-- Bouton de soumission --}}
        </form>
    </div>
@endsection