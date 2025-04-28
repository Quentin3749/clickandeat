{{-- 
    Tableau de bord utilisateur (tous rôles)
    - Affiche les informations personnalisées selon le rôle (admin, restaurateur, client)
    - Utilise Bootstrap/Tailwind pour la mise en page
--}}
@extends('layout.main')

@section('main')
<!--begin::Container-->
<div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          {{-- <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li> --}}
          <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
      </div>
    </div>
    <!--end::Row-->
    <div class="container"> {{-- Conteneur principal Bootstrap --}}
        <div class="row"> {{-- Grille principale --}}
            <div class="col-md-12"> {{-- Colonne pleine largeur --}}
                <div class="card"> {{-- Carte Bootstrap --}}
                    <div class="card-body">
                        <h1 class="card-title">Bienvenue sur votre tableau de bord</h1>
                        <p class="card-text">Résumé de l'activité et accès rapides.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Container-->
@endsection

{{-- 
@section('main')
    <h1>Dashboard</h1>

    <a href="{{ route('categories.index') }}">categories</a>
    <a href="{{ route('restaurants.index') }}">restaurants</a>
@endsection

@section('scripts')
@endsection --}}