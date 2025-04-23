@extends('layout.main')

    @section('main')
        <h1>Catégorie : {{ $category->name }}</h1>
        <p>ID : {{ $category->id }}</p>
        <p>Restaurant : {{ $category->restaurant->name }}</p>
        <a href="{{ route('categories.index') }}">Retour à la liste des catégories</a>
    @endsection