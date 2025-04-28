@extends('layout.main')


@section('main')
{{-- Vue d'index des restaurants --}}
{{-- - Affiche la liste des restaurants disponibles --}}
{{-- - Utilise Bootstrap/Tailwind pour la mise en page --}}
{{-- - Explique chaque colonne, bouton d'action, et structure du tableau --}}
<div class="card mb-4">
    <div class="card-header"><h3 class="card-title">Restaurants</h3></div>
    {{-- Bouton d'ajout --}}
    <a href="{{ route('restaurants.create') }}">Créer un restaurant</a> <br>  <a href="{{ route('categories.index') }}"> liste des catégorie</a>
    <!-- /.card-header -->
    <div class="card-body">
      {{-- Tableau Bootstrap --}}
      <table class="table table-bordered" border="2">
        <thead>
          <tr>
            {{-- Colonne ID --}}
            <th style="width: 10px">id</th>
            {{-- Colonne Nom --}}
            <th>Nom</th>
            {{-- Colonne Restaurateur --}}
            <th>Restaurateur</th> 
            {{-- Colonne Actions --}}
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
            {{-- Boucle foreach pour afficher les restaurants --}}
            @foreach($restaurants as $restaurant)
                <tr class="align-middle">
                    {{-- Affichage de l'ID --}}
                    <td>{{ $restaurant->id }}</td>
                    {{-- Affichage du nom --}}
                    <td>{{ $restaurant->name }}</td>
                    {{-- Affichage du restaurateur --}}
                    <td>@if($restaurant->user)
                    {{ $restaurant->user->name }}
                @else
                    Non associé
                @endif</td> 
                    {{-- Boutons d'actions --}}
                    <td>
                        <div style="display: flex;">
                            {{-- Bouton voir --}}
                            <a class="btn btn-info mx-2" href="{{ route('restaurants.show', $restaurant->id) }}">Voir</a>
                            {{-- Bouton modifier --}}
                            <a class="btn btn-warning mx-2" href="{{ route('restaurants.edit', $restaurant->id) }}">Modifier</a>
                            {{-- Formulaire de suppression --}}
                            <form action="{{ route('restaurants.destroy', $restaurant->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="id" value="{{ $restaurant->id }}">
                                {{-- Bouton supprimer --}}
                                <button type="submit" class="btn btn-danger mx-2">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection

@section('scripts')
    <script>
        console.log("scripts !");
    </script>
@endsection