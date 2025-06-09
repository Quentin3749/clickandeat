{{--
    Vue du menu d'un restaurant
    - Affiche la liste des plats proposés par le restaurant
    - Utilise Bootstrap/Tailwind pour la mise en page
    - Explique chaque section, boucle, et bouton d'action
--}}
@extends('layouts.app')

@section('content')
    {{-- Conteneur principal Bootstrap --}}
    <div class="container">
        {{-- Titre du menu --}}
        <h1>Menu de {{ $restaurant->name }}</h1>

        {{-- Vérification si le menu est vide --}}
        @if ($menuItems->isEmpty())
            {{-- Message si le menu est vide --}}
            <p>Ce restaurant n'a pas encore de plats au menu.</p>
        @else
            {{-- Boucle sur les catégories de plats --}}
            @foreach ($menuItems as $categoryName => $items)
                {{-- Section pour chaque catégorie --}}
                <div class="mb-4">
                    {{-- Titre de la catégorie --}}
                    <h2>{{ $categoryName }}</h2>
                    {{-- Liste des plats de la catégorie --}}
                    <ul class="list-unstyled">
                        {{-- Boucle sur les plats de la catégorie --}}
                        @foreach ($items as $item)
                            {{-- Élément de la liste pour chaque plat --}}
                            <li>
                                {{-- Nom du plat --}}
                                <strong>{{ $item->name }}</strong> - {{ $item->price }} €
                                {{-- Description du plat si disponible --}}
                                @if ($item->description)
                                    <p class="text-muted">{{ $item->description }}</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        @endif

        {{-- Bouton pour retourner à la liste des restaurants --}}
        <a href="{{ route('restaurants.index') }}" class="btn btn-secondary mt-3">Retour à la liste des restaurants</a>
    </div>
@endsection