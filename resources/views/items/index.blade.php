{{--
    Vue d'index des items
    - Affiche la liste des plats/items disponibles
    - Utilise Bootstrap/Tailwind pour la mise en page
    - Affiche des boutons pour créer, éditer ou supprimer un item
--}}
@extends('layouts.app')

@section('content')
    <div class="container"> {{-- Conteneur principal Bootstrap --}}
        <h1 class="mb-4">Liste des Items</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('items.create') }}" class="btn btn-primary mb-3">Créer un nouvel item</a> {{-- Bouton d'ajout --}}

        @if($items->isNotEmpty())
            <table class="table table-striped"> {{-- Tableau Bootstrap --}}
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Catégorie</th>
                        <th>Actif</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td> {{-- Nom du plat --}}
                            <td>{{ $item->price }}</td> {{-- Prix --}}
                            <td>{{ $item->category->name ?? 'Non catégorisé' }}</td> {{-- Catégorie associée --}}
                            <td>{{ $item->is_active ? 'Oui' : 'Non' }}</td>
                            <td>
                                <a href="{{ route('items.show', $item->id) }}" class="btn btn-info btn-sm">Voir</a>
                                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm">Éditer</a> {{-- Bouton éditer --}}
                                <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet item ?')">Supprimer</button> {{-- Bouton supprimer --}}
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $items->links() }}
        @else
            <p>Aucun item trouvé.</p>
        @endif
    </div>
@endsection