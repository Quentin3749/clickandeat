@extends('layout.main')

@section('main')
    <h1>Restaurants</h1>

    <a href="{{ route('restaurants.index') }}">Retour à la liste</a>
    <a href="{{ route('restaurants.create') }}">Créer un restaurant</a>

    <div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $restaurant->name }}</h5>
        <p class="card-text"><strong>ID:</strong> {{ $restaurant->id }}</p>
        <p class="card-text"><strong>Restaurateur:</strong> {{ $restaurant->user->name }}</p>
        <p class="card-text"><strong>Créé le:</strong> {{ $restaurant->created_at }}</p>
        <p class="card-text"><strong>Modifié le:</strong> {{ $restaurant->updated_at }}</p>
    </div>
</div>

<h2>Catégories</h2>
@if(count($restaurant->categories) > 0)
    <ul class="list-group">
        @foreach($restaurant->categories as $category)
            <li class="list-group-item">
                <a href="{{ route('categories.show', $category->id) }}" title="Voir la catégorie">{{ $category->name }}</a>
            </li>
        @endforeach
    </ul>
@else
    <p>Ce restaurant n'a pas de catégories associées.</p>
@endif
@endsection