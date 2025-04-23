@extends('layout.main')


@section('main')
<div class="card mb-4">
    <div class="card-header"><h3 class="card-title">Restaurants</h3></div>
    <a href="{{ route('restaurants.create') }}">Créer un restaurant</a> <br>  <a href="{{ route('categories.index') }}"> liste des catégorie</a>
    <!-- /.card-header -->
    <div class="card-body">
      <table class="table table-bordered" border="2">
        <thead>
          <tr>
            <th style="width: 10px">id</th>
            <th>Nom</th>
            <th>Restaurateur</th> <th>Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach($restaurants as $restaurant)
                <tr class="align-middle">
                    <td>{{ $restaurant->id }}</td>
                    <td>{{ $restaurant->name }}</td>
                    <td>@if($restaurant->user)
                    {{ $restaurant->user->name }}
                @else
                    Non associé
                @endif</td> <td>
                    <td>
                        <div style="display: flex;">
                            <a class="btn btn-info mx-2" href="{{ route('restaurants.show', $restaurant->id) }}">Voir</a>
                            <a class="btn btn-warning mx-2" href="{{ route('restaurants.edit', $restaurant->id) }}">Modifier</a>
                            <form action="{{ route('restaurants.destroy', $restaurant->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="id" value="{{ $restaurant->id }}">
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