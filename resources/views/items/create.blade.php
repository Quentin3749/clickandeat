@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Créer un nouvel item</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('items.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="cost" class="form-label">Coût</label>
                <input type="number" step="0.01" class="form-control" id="cost" name="cost" value="{{ old('cost') }}">
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Prix</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Catégorie</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">Sélectionner une catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Actif</label>
            </div>

            <button type="submit" class="btn btn-primary">Créer</button>
            <a href="{{ route('items.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection