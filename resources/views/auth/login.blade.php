<!DOCTYPE html>
<html lang="en">
    <head>
        {{-- 
            En-tête HTML
            - Définit la langue et les métadonnées de la page
            - Inclut les feuilles de style et les polices
        --}}
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
        <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    </head>
    <body>
        {{-- 
            Barre de navigation
            - Utilise Bootstrap pour la mise en page
            - La classe .navbar-expand-lg définit la largeur de la barre de navigation
        --}}
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="navbar-brand" href="#!">connection</a>
            </div>
        </nav>
        {{-- 
            Contenu principal
            - Utilise Bootstrap pour la mise en page
            - La classe .container définit le conteneur principal
            - La classe .d-flex définit la disposition en flexbox
        --}}
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
            {{-- 
                Colonne de contenu
                - Utilise Bootstrap pour la mise en page
                - La classe .col-md-6 définit la largeur de la colonne
            --}}
            <div class="col-md-6">
                {{-- 
                    Carte de connexion
                    - Utilise Bootstrap pour la mise en page
                    - La classe .card définit la carte
                --}}
                <div class="card shadow p-4 border-0 rounded-4 animate__animated animate__fadeInDown">
                    {{-- 
                        Corps de la carte
                        - Contient le formulaire de connexion
                    --}}
                    <div class="card-body">
                        {{-- 
                            Titre de la carte
                            - Utilise la police Poppins et la couleur #2563eb
                        --}}
                        <h1 class="text-center mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 700; color: #2563eb; letter-spacing: 2px;">Click & Eat</h1>
                        {{-- 
                            État de la session
                            - Affiche les messages de la session
                        --}}
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        {{-- 
                            Formulaire de connexion
                            - Utilise la méthode POST et la route de connexion
                            - Contient les champs email et mot de passe
                        --}}
                        <form method="POST" action="{{ route('login') }}" class="mt-4">
                            @csrf
                            {{-- 
                                Champ email
                                - Utilise la classe .mb-3 pour la marge inférieure
                                - Utilise la classe .form-label pour le label
                            --}}
                            <div class="mb-3">
                                <x-input-label for="email" :value="__('Email')" class="form-label" />
                                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="text-danger mt-2" />
                            </div>
                            {{-- 
                                Champ mot de passe
                                - Utilise la classe .mb-3 pour la marge inférieure
                                - Utilise la classe .form-label pour le label
                            --}}
                            <div class="mb-3">
                                <x-input-label for="password" :value="__('Password')" class="form-label" />
                                <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
                                <x-input-error :messages="$errors->get('password')" class="text-danger mt-2" />
                            </div>
                            {{-- 
                                Checkbox de rappel
                                - Utilise la classe .mb-3 pour la marge inférieure
                                - Utilise la classe .form-check pour le checkbox
                            --}}
                            <div class="mb-3 form-check">
                                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
                            </div>
                            {{-- 
                                Bouton de connexion
                                - Utilise la classe .btn pour le bouton
                                - Utilise la classe .btn-primary pour la couleur
                            --}}
                            <div class="d-flex justify-content-between align-items-center">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-primary">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif
                                <x-primary-button class="btn btn-primary px-4 shadow">{{ __('Log in') }}</x-primary-button>
                            </div>
                        </form>
                        {{-- 
                            Lien d'inscription
                            - Utilise la classe .mt-4 pour la marge supérieure
                            - Utilise la classe .text-center pour le centrage
                        --}}
                        <div class="mt-4 text-center">
                            <span>Pas encore de compte ? <a href="{{ route('register') }}" class="text-primary fw-bold">Inscription</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- 
            Scripts et feuilles de style
            - Inclut les scripts et les feuilles de style nécessaires
        --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets/js/scripts.js') }}"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <style>
            body { background: linear-gradient(135deg, #e0e7ff 0%, #f1f5f9 100%); }
            .card { background: #fff; border-radius: 1.5rem; }
            .form-label { font-weight: 600; }
            .btn-primary { background: #2563eb; border: none; }
            .btn-primary:hover { background: #1d4ed8; }
            a.text-primary { text-decoration: underline; }
        </style>
    </body>
</html>