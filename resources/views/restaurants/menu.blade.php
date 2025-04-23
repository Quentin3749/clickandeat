@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Menu de {{ $restaurant->name }}</h1>

        @if ($menuItems->isEmpty())
            <p>Ce restaurant n'a pas encore de plats au menu.</p>
        @else
            @foreach ($menuItems as $categoryName => $items)
                <div class="mb-4">
                    <h2>{{ $categoryName }}</h2>
                    <ul class="list-unstyled">
                        @foreach ($items as $item)
                            <li>
                                <strong>{{ $item->name }}</strong> - {{ $item->price }} €
                                @if ($item->description)
                                    <p class="text-muted">{{ $item->description }}</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        @endif

        <a href="{{ route('restaurants.index') }}" class="btn btn-secondary mt-3">Retour à la liste des restaurants</a>
    </div>
@endsection