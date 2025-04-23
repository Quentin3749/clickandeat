@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Détails de l'item</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $item->name }}</h5>
                <p class="card-text"><strong>ID:</strong> {{ $item->id }}</p>
                <p class="card-text"><strong>Coût:</strong> {{ $item->cost }}</p>
                <p class="card-text"><strong>Prix:</strong> {{ $item->price }}</p>
                <p class="card-text"><strong>Catégorie:</strong> {{ $item->category->name ?? 'Non catégorisé' }}</p>
                <p class="card-text"><strong>Actif:</strong> {{ $item->is_active ? 'Oui' : 'Non' }}</p>
                <p class="card-text"><strong>Créé le:</strong> {{ $item->created_at }}</p>
                <p class="card-text"><strong>Modifié le:</strong> {{ $item->updated_at }}</p>
                <a href="{{ route('items.index') }}" class="btn btn-primary">Retour à la liste</a>
            </div>
        </div>
    </div>
@endsection