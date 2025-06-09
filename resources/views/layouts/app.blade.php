{{--
    Layout principal de l'application
    - Définit la structure HTML commune à toutes les pages authentifiées
    - Contient l'inclusion du header, du menu de navigation, et du contenu principal
    - Utilise Bootstrap/Tailwind pour la mise en page
    - Explique chaque section et inclusion
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {{-- Inclusion de l'en-tête (métadonnées, CSS, scripts) --}}
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Click & Eat') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Anton:wght@400&family=Poppins:wght@400;700;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        @stack('styles')
        <style>
            body {
                min-height: 100vh;
                background: linear-gradient(135deg, #e0e7ff 0%, #f1f5f9 100%) !important;
                color: #222;
                font-family: 'Poppins', 'Anton', Impact, sans-serif;
            }
            .main-title {
                font-family: 'Anton', Impact, sans-serif;
                font-size: 2.5rem;
                color: #ffb52a;
                text-shadow: 2px 2px 0 #222, 4px 4px 0 #bfa14a;
                letter-spacing: 2px;
                margin-bottom: 0.2em;
            }
            .btn-main, .btn-primary, .btn-success {
                background: #bfa14a !important;
                color: #fff !important;
                border: none;
                border-radius: 30px;
                font-family: 'Anton', Impact, sans-serif;
                letter-spacing: 1px;
                font-size: 1.1rem;
                padding: 10px 28px;
            }
            .btn-main:hover, .btn-primary:hover, .btn-success:hover {
                background: #ffb52a !important;
                color: #222 !important;
            }
            .dashboard-card, .restaurant-card, .reservation-card {
                background: #fff;
                border-radius: 1.5rem;
                box-shadow: 0 6px 32px rgba(44,62,80,0.10);
                color: #222;
            }
            .dashboard-title {
                font-family: 'Poppins', sans-serif;
                color: #2563eb;
                font-weight: 800;
                letter-spacing: 1px;
                text-shadow: 1px 1px 0 #e0e7ff;
            }
            .navbar {
                background: #222 !important;
            }
            .navbar-brand, .navbar-nav .nav-link, .navbar-text {
                color: #ffb52a !important;
                font-family: 'Anton', Impact, sans-serif;
                letter-spacing: 2px;
                font-size: 1.3rem;
            }
            .navbar-brand img {
                width: 50px;
                height: 50px;
                object-fit: contain;
                border-radius: 50%;
                border: 2px solid #bfa14a;
                background: #222;
                margin-right: 10px;
            }
            .form-label, .form-control, .form-select {
                color: #222 !important;
                background: #f8fafc !important;
                border: 1px solid #bfa14a !important;
            }
            .form-control:focus, .form-select:focus {
                border-color: #ffb52a !important;
                box-shadow: 0 0 0 2px #bfa14a44;
            }
            .alert-info {
                background: #bfa14a22;
                color: #ffb52a;
                border: none;
            }
            footer {
                color: #bfa14a;
                background: transparent;
            }
        </style>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body style="background: none;">
        {{-- Suppression du logo Laravel, du header et de tout ce qui est présent sur la capture --}}
        @auth
            @if(auth()->user()->isClient())
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="/client/dashboard">Espace Client</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('client.cart') }}">
                                        <i class="bi bi-cart"></i> Mon Panier
                                        @php $cart = session('cart', []); @endphp
                                        @if(!empty($cart))
                                            <span class="badge bg-danger">{{ array_sum($cart) }}</span>
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            @endif
        @endauth
        @yield('content')
    </body>
</html>