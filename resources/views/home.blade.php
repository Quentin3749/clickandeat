{{-- 
    Vue d'accueil principale pour les utilisateurs connectés
    - Affiche une barre de recherche et des filtres pour les restaurants
    - Affiche la liste des restaurants sous forme de cartes
    - Les données attendues :
        $restaurants : Collection des restaurants à afficher
        $cuisineTypes : Liste des types de cuisine disponibles
        $priceRanges : Liste des gammes de prix disponibles
    - Les filtres sont transmis via GET à la même route
--}}

@extends('layouts.app')

@section('content')
<div class="container"> {{-- Conteneur principal Bootstrap pour centrer et limiter la largeur du contenu --}}
    <!-- Barre de recherche et filtres -->
    <div class="card mb-4"> {{-- Carte Bootstrap avec une marge inférieure --}}
        <div class="card-body"> {{-- Corps de la carte, pour le contenu interne --}}
            {{-- Formulaire de recherche et de filtrage des restaurants --}}
            <form action="{{ route('home') }}" method="GET" class="row g-3"> {{-- Grille Bootstrap avec un espacement vertical entre les lignes --}}
                <div class="col-md-4"> {{-- Colonne prenant 4/12 de la largeur sur écran moyen et plus --}}
                    <input type="text" class="form-control" name="search" placeholder="Rechercher un restaurant..." value="{{ request('search') }}"> {{-- Champ texte pour la recherche --}}
                </div>
                <div class="col-md-3"> {{-- Colonne pour le filtre type de cuisine --}}
                    <select class="form-select" name="cuisine"> {{-- Liste déroulante Bootstrap --}}
                        <option value="">Type de cuisine</option>
                        @foreach($cuisineTypes as $type)
                            <option value="{{ $type }}" {{ request('cuisine') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3"> {{-- Colonne pour le filtre gamme de prix --}}
                    <select class="form-select" name="price"> {{-- Liste déroulante Bootstrap --}}
                        <option value="">Gamme de prix</option>
                        @foreach($priceRanges as $range)
                            <option value="{{ $range }}" {{ request('price') == $range ? 'selected' : '' }}>{{ $range }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2"> {{-- Colonne pour le bouton --}}
                    <button type="submit" class="btn btn-primary w-100"> {{-- Bouton bleu Bootstrap qui prend toute la largeur --}}
                        Filtrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des restaurants -->
    <div class="row row-cols-1 row-cols-md-3 g-4"> {{-- Grille responsive Bootstrap : 1 colonne sur mobile, 3 sur desktop, avec espacement --}}
        {{-- Boucle sur les restaurants à afficher --}}
        @forelse($restaurants as $restaurant)
            <div class="col"> {{-- Colonne individuelle pour chaque restaurant --}}
                <div class="card h-100"> {{-- Carte qui prend toute la hauteur de la colonne --}}
                    @if($restaurant->image_url)
                        <img src="{{ $restaurant->image_url }}" class="card-img-top" alt="{{ $restaurant->name }}" style="height: 200px; object-fit: cover;"> {{-- Image du restaurant --}}
                    @else
                        <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;"> {{-- Placeholder si pas d'image --}}
                            <i class="fas fa-utensils fa-3x"></i>
                        </div>
                    @endif
                    <div class="card-body"> {{-- Corps de la carte : infos du restaurant --}}
                        <h5 class="card-title">{{ $restaurant->name }}</h5> {{-- Titre du restaurant --}}
                        <p class="card-text text-muted">
                            @if($restaurant->cuisine_type)
                                <span class="badge bg-info">{{ $restaurant->cuisine_type }}</span> {{-- Badge pour le type de cuisine --}}
                            @endif
                            @if($restaurant->price_range)
                                <span class="badge bg-secondary">{{ $restaurant->price_range }}</span> {{-- Badge pour la gamme de prix --}}
                            @endif
                        </p>
                        <p class="card-text">{{ Str::limit($restaurant->description, 100) }}</p> {{-- Description du restaurant, tronquée à 100 caractères --}}
                        <p class="card-text small text-muted">
                            <i class="fas fa-map-marker-alt"></i> {{ $restaurant->address }} {{-- Adresse du restaurant --}}
                        </p>
                    </div>
                    <div class="card-footer"> {{-- Pied de la carte : lien vers le menu --}}
                        <a href="{{ route('restaurants.show', $restaurant) }}" class="btn btn-outline-primary w-100"> {{-- Bouton pour voir le menu --}}
                            Voir le menu
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Aucun restaurant ne correspond à vos critères de recherche. {{-- Message si pas de résultats --}}
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $restaurants->links() }} {{-- Liens de pagination --}}
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s; {{-- Animation pour les cartes --}}
    }
    .card:hover {
        transform: translateY(-5px); {{-- Effet de survol pour les cartes --}}
    }
</style>
@endpush
