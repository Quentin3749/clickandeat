@extends('layout.main')

@section('main')
    <h1>Creation restaurant</h1>

    <a href="{{ route('restaurants.index') }}">Retour à la liste</a>

    <form action="{{ route('restaurants.store') }}" method="POST" class="form">
    @csrf
    <div class="form-group">
        <label for="name">Nom : </label>
        <input type="text" id="name" name="name" placeholder="Nom" class="form-control">
    </div>

    <div class="form-group">
        <label for="user_id">Restaurateur : </label>
        <select name="user_id" id="user_id" class="form-control">
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>
@endsection