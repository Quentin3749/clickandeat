{{--
    Layout pour les pages invitées (non authentifiées)
    - Structure HTML simplifiée pour les pages de connexion, inscription, etc.
    - Utilise Bootstrap/Tailwind pour la mise en page
    - Explique chaque section et inclusion
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    {{-- Inclusion de l'en-tête (métadonnées, CSS, scripts) --}}
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Click & Eat') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Anton:wght@400&display=swap" rel="stylesheet">
        <style>
            body {
                min-height: 100vh;
                background: linear-gradient(135deg, #222 0%, #3a2c0f 40%, #bfa14a 100%) !important;
                color: #fff;
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
                background: #222b;
                border-radius: 1.5rem;
                box-shadow: 0 6px 32px rgba(44,62,80,0.18);
                color: #fff;
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
                color: #fff !important;
                background: #222a !important;
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
    <body class="font-sans text-gray-900 antialiased">
        {{-- Contenu principal de la page invité --}}
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
