{{--
    Vue d'édition de restaurant
    - Affiche un formulaire pour modifier un restaurant existant
    - Utilise Bootstrap/Tailwind pour la mise en page
    - Explique chaque champ et bouton du formulaire
--}}
@extends('layout.main')

@section('main')
    {{--
        Titre de la page
    --}}
    <h1>Modification restaurant</h1>

    {{--
        Lien de retour à la liste des restaurants
    --}}
    <a href="{{ route('restaurants.index') }}">Retour à la liste</a>

    {{--
        Formulaire d'édition de restaurant
    --}}
    <form action="{{ route('restaurants.update', $restaurant->id) }}" method="POST" class="form" enctype="multipart/form-data">
    @csrf
    @method('put')
    {{--
        Champ nom du restaurant
    --}}
    <div class="form-group">
        <label for="name">Nom : </label>
        <input type="text" id="name" name="name" placeholder="Nom" value="{{ $restaurant->name }}" class="form-control">
    </div>

    {{--
        Champ restaurateur
    --}}
    <div class="form-group">
        <label for="user_id">Restaurateur : </label>
        <select name="user_id" id="user_id" class="form-control">
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $restaurant->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    {{--
        Champ couleur principale
    --}}
    <div class="form-group">
        <label for="primary_color">Couleur principale :</label>
        <input type="color" id="primary_color" name="primary_color" value="{{ $restaurant->primary_color ?? '#2563eb' }}" class="form-control" style="width: 60px; height: 36px; padding: 0;">
    </div>

    {{--
        Champ logo
    --}}
    <div class="form-group">
        <label for="logo_path">Logo :</label>
        <input type="file" id="logo_path" name="logo_path" class="form-control">
        @if($restaurant->logo_path)
            <div class="mt-2"><img src="{{ $restaurant->getLogoUrl() }}" alt="Logo" style="max-height: 80px;"></div>
        @endif
    </div>

    {{--
        Bouton de soumission
    --}}
    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>
@endsection