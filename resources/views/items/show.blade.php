{{--
    Vue de détail d'un item (plat)
    - Affiche les informations détaillées d'un plat
    - Utilise Bootstrap/Tailwind pour la mise en page
    - Explique chaque section et bouton
--}}
@extends('layouts.app')
@section('content')
<div class="container"> {{-- Conteneur principal Bootstrap --}}
    <h1 class="mb-4">Détails de l'item</h1>
    <div class="card mb-3"> {{-- Carte Bootstrap --}}
        <div class="card-body">
            <h5 class="card-title">{{ $item->name }}</h5> {{-- Nom du plat --}}
            <p class="card-text"><strong>ID:</strong> {{ $item->id }}</p>
            <p class="card-text"><strong>Coût:</strong> {{ $item->cost }}</p>
            <p class="card-text"><strong>Prix:</strong> {{ $item->price }}</p>
            <p class="card-text"><strong>Catégorie:</strong> {{ $item->category->name ?? 'Non catégorisé' }}</p>
            <p class="card-text"><strong>Actif:</strong> {{ $item->is_active ? 'Oui' : 'Non' }}</p>
            <p class="card-text"><strong>Créé le:</strong> {{ $item->created_at }}</p>
            <p class="card-text"><strong>Modifié le:</strong> {{ $item->updated_at }}</p>
        </div>
    </div>
    <a href="{{ route('items.index') }}" class="btn btn-primary">Retour à la liste</a> {{-- Bouton retour --}}
</div>
@endsection