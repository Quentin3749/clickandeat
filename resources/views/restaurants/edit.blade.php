@extends('layout.main')

@section('main')
    <h1>Modification restaurant</h1>

    <a href="{{ route('restaurants.index') }}">Retour à la liste</a>

    <form action="{{ route('restaurants.update', $restaurant->id) }}" method="POST" class="form">
    @csrf
    @method('put')
    <div class="form-group">
        <label for="name">Nom : </label>
        <input type="text" id="name" name="name" placeholder="Nom" value="{{ $restaurant->name }}" class="form-control">
    </div>

    <div class="form-group">
        <label for="user_id">Restaurateur : </label>
        <select name="user_id" id="user_id" class="form-control">
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $restaurant->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>
@endsection