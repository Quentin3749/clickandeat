{{--
    Vue de création de réservation
    - Affiche un formulaire pour réserver une table dans un restaurant
    - Utilise Bootstrap/Tailwind pour la mise en page
    - Explique chaque champ et bouton du formulaire
--}}
@extends('layouts.app')

@section('content')
<div class="container max-w-lg mx-auto mt-5"> {{-- Conteneur principal Bootstrap --}}
    <h2 class="text-2xl font-bold mb-4">Réserver une table chez {{ $restaurant->name }}</h2>
    <form method="POST" action="{{ route('reservations.store', $restaurant) }}"> {{-- Formulaire de création de réservation --}}
        @csrf
        <div class="mb-4">
            <label for="date" class="block font-semibold">Date</label>
            <input type="date" id="date" name="date" class="form-input w-full" required value="{{ old('date') }}"> {{-- Champ date --}}
            @error('date')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label for="time" class="block font-semibold">Heure</label>
            <input type="time" id="time" name="time" class="form-input w-full" required value="{{ old('time') }}"> {{-- Champ heure --}}
            @error('time')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label for="guests" class="block font-semibold">Nombre de couverts</label>
            <input type="number" id="guests" name="guests" class="form-input w-full" min="1" max="20" required value="{{ old('guests', 2) }}"> {{-- Champ nombre de personnes --}}
            @error('guests')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label for="notes" class="block font-semibold">Notes (optionnel)</label>
            <textarea id="notes" name="notes" class="form-input w-full">{{ old('notes') }}</textarea> {{-- Champ notes --}}
            @error('notes')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-primary w-full">Réserver</button> {{-- Bouton de soumission --}}
    </form>
</div>
@endsection
