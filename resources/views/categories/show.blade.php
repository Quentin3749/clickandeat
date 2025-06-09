@extends('layout.main')

    @section('main')
        {{-- Vue de détail d'une catégorie --}}
        {{-- Affiche les informations détaillées d'une catégorie --}}
        {{-- Utilise Bootstrap/Tailwind pour la mise en page --}}
        {{-- Explique chaque section et bouton --}}
        <h1>Catégorie : {{ $category->name }}</h1> {{-- Nom de la catégorie --}}
        <p>ID : {{ $category->id }}</p> {{-- ID de la catégorie --}}
        <p>Restaurant : {{ $category->restaurant->name }}</p> {{-- Restaurant associé --}}
        <a href="{{ route('categories.index') }}">Retour à la liste des catégories</a> {{-- Bouton retour --}}
    @endsection