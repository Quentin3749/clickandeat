{{-- 
    Tableau de bord administrateur (vue alternative ou sous-section)
    - Affiche des informations spécifiques pour l'admin
    - Utilise Bootstrap/Tailwind pour la mise en page
--}}
@extends('layouts.app')
@section('content')
<div class="container py-5"> {{-- Conteneur principal Bootstrap --}}
    <div class="mb-4 text-center">
        <h1 class="display-5 fw-bold" style="color:#2563eb;letter-spacing:2px;">Tableau de bord Administrateur</h1>
        <p class="lead">Bienvenue sur l'espace d'administration de <b>Click & Eat</b> !</p>
    </div>
    <div class="row g-4"> {{-- Grille principale --}}
        <div class="col-md-4"> {{-- Colonne 1/3 --}}
            <div class="card shadow border-0 rounded-4 animate__animated animate__fadeInUp"> {{-- Carte Bootstrap --}}
                <div class="card-body text-center">
                    <i class="fas fa-store fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">Restaurants</h5>
                    <p class="card-text">Gérez la liste des restaurants, ajoutez ou modifiez les informations.</p>
                    <a href="{{ route('restaurants.index') }}" class="btn btn-outline-primary">Voir les restaurants</a>
                </div>
            </div>
        </div>
        <div class="col-md-4"> {{-- Colonne 2/3 --}}
            <div class="card shadow border-0 rounded-4 animate__animated animate__fadeInUp" style="animation-delay:0.1s;"> {{-- Carte Bootstrap --}}
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x mb-3 text-success"></i>
                    <h5 class="card-title">Utilisateurs</h5>
                    <p class="card-text">Consultez et gérez les comptes administrateurs, restaurateurs et clients.</p>
                    <a href="#" class="btn btn-outline-success disabled">Gestion utilisateurs</a>
                </div>
            </div>
        </div>
        <div class="col-md-4"> {{-- Colonne 3/3 --}}
            <div class="card shadow border-0 rounded-4 animate__animated animate__fadeInUp" style="animation-delay:0.2s;"> {{-- Carte Bootstrap --}}
                <div class="card-body text-center">
                    <i class="fas fa-utensils fa-3x mb-3 text-warning"></i>
                    <h5 class="card-title">Commandes & Réservations</h5>
                    <p class="card-text">Supervisez les commandes, réservations et leur statut en temps réel.</p>
                    <a href="#" class="btn btn-outline-warning disabled">Suivi global</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12 text-center">
            <small class="text-muted">Dernière connexion : {{ Auth::user()->updated_at->format('d/m/Y H:i') }}</small>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
    body { background: linear-gradient(135deg, #e0e7ff 0%, #f1f5f9 100%); }
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 8px 24px 0 rgba(37,99,235,0.10); }
</style>
@endsection
