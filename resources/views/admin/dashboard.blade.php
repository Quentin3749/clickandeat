@extends('layouts.app')
@section('content')
<style>
    .admin-dashboard-bg {
        background: linear-gradient(135deg, #e0e7ff 0%, #f1f5f9 100%) !important;
        min-height: 100vh;
        padding-top: 40px;
    }
    .admin-dashboard-title {
        font-family: 'Poppins', sans-serif;
        color: #232526;
        font-size: 2.1rem;
        letter-spacing: 1px;
        margin-bottom: 1.5rem;
        text-align: center;
        font-weight: 700;
    }
    .admin-card {
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 8px 40px rgba(44,62,80,0.10);
        color: #232526;
        border: 2.5px solid #bfa14a;
        transition: transform .15s, border .15s;
    }
    .admin-card:hover {
        transform: translateY(-5px) scale(1.03);
        border-color: #ffb52a;
    }
    .admin-card .icon {
        font-size: 2.7rem;
        margin-bottom: 0.5rem;
        color: #bfa14a;
    }
    .admin-btn-action {
        background: #bfa14a;
        color: #fff;
        border-radius: 25px;
        border: none;
        font-weight: bold;
        font-family: 'Poppins', sans-serif;
        letter-spacing: 1px;
        padding: 8px 32px;
        margin-top: 1rem;
        transition: background .2s, color .2s;
    }
    .admin-btn-action:hover {
        background: #ffb52a;
        color: #232526;
    }
    .admin-quick-actions a {
        background: #fff;
        color: #bfa14a;
        border-radius: 25px;
        border: 2px solid #bfa14a;
        font-weight: bold;
        font-family: 'Poppins', sans-serif;
        letter-spacing: 1px;
        padding: 8px 28px;
        margin: 0 10px 10px 0;
        transition: background .2s, color .2s, border .2s;
        display: inline-block;
    }
    .admin-quick-actions a:hover {
        background: #bfa14a;
        color: #fff;
        border-color: #ffb52a;
    }
    .admin-logout {
        position: absolute;
        top: 1.5rem;
        right: 2rem;
    }
</style>
<div class="admin-dashboard-bg">
    <div class="admin-logout">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Se déconnecter</button>
        </form>
    </div>
    <div class="admin-dashboard-title">Tableau de bord administrateur</div>
    <div class="d-flex flex-wrap justify-content-center gap-5">
        <div class="admin-card p-5 text-center w-80">
            <div class="icon">🏬</div>
            <h3 class="fw-bold mb-2">Restaurants</h3>
            <p>Gérez la liste des restaurants, ajoutez ou modifiez les informations.</p>
            <a href="{{ route('admin.restaurants.index') }}" class="admin-btn-action">Voir les restaurants</a>
        </div>
        <div class="admin-card p-5 text-center w-80">
            <div class="icon">👥</div>
            <h3 class="fw-bold mb-2">Utilisateurs</h3>
            <p>Consultez et gérez les comptes administrateurs, restaurateurs et clients.</p>
            <a href="{{ route('admin.users.index') }}" class="admin-btn-action">Gestion utilisateurs</a>
        </div>
        <div class="admin-card p-5 text-center w-80">
            <div class="icon">🍽️</div>
            <h3 class="fw-bold mb-2">Commandes & Réservations</h3>
            <p>Supervisez les commandes, réservations et leur statut en temps réel.</p>
            <a href="{{ route('admin.orders.index') }}" class="admin-btn-action">Suivi global</a>
        </div>
    </div>
    <div class="admin-quick-actions text-center mt-5">
        <a href="{{ route('admin.users.create') }}">➕ Nouvel utilisateur</a>
        <a href="{{ route('admin.restaurants.create') }}">➕ Nouveau restaurant</a>
    </div>
    <div class="text-center text-dark mt-5" style="opacity:0.7;">
        Dernière connexion : {{ now()->format('d/m/Y H:i') }}
    </div>
</div>
@endsection
