<!DOCTYPE html>
<html lang="en">
    <head>
        {{-- 
            En-tête HTML
            - Définit le jeu de caractères (UTF-8)
            - Définit la taille de la fenêtre (width=device-width, initial-scale=1, shrink-to-fit=no)
            - Définit la description et l'auteur de la page
            - Définit le titre de la page (Reset Password)
            - Inclut les fichiers CSS et favicon
        --}}
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Reset Password</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
        <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    </head>
    <body>
        {{-- 
            Barre de navigation
            - Utilise Bootstrap pour la mise en page
            - Les classes .navbar, .navbar-expand-lg, .navbar-dark, .bg-dark structurent la barre de navigation
        --}}
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="navbar-brand" href="#!">Start Bootstrap</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Services</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        {{-- 
            Contenu principal
            - Utilise Bootstrap pour la mise en page
            - Les classes .container, .px-4, .px-lg-5 structurent la page et centrent le contenu
        --}}
        <div class="container px-4 px-lg-5">
            {{-- 
                Formulaire de réinitialisation du mot de passe
                - Utilise Bootstrap pour la mise en page
                - Les classes .card, .card-header, .card-body structurent le formulaire
            --}}
            <x-guest-layout>
                <form method="POST" action="{{ route('password.store') }}" class="mt-4">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    {{-- 
                        Champ e-mail
                        - Utilise Bootstrap pour la mise en page
                        - Les classes .mb-3, .form-label, .form-control structurent le champ
                    --}}
                    <div class="mb-3">
                        <x-input-label for="email" :value="__('Email')" class="form-label" />
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="text-danger mt-2" />
                    </div>
                    {{-- 
                        Champ mot de passe
                        - Utilise Bootstrap pour la mise en page
                        - Les classes .mb-3, .form-label, .form-control structurent le champ
                    --}}
                    <div class="mb-3">
                        <x-input-label for="password" :value="__('Password')" class="form-label" />
                        <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="text-danger mt-2" />
                    </div>
                    {{-- 
                        Champ confirmation du mot de passe
                        - Utilise Bootstrap pour la mise en page
                        - Les classes .mb-3, .form-label, .form-control structurent le champ
                    --}}
                    <div class="mb-3">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="form-label" />
                        <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger mt-2" />
                    </div>
                    {{-- 
                        Bouton de réinitialisation
                        - Utilise Bootstrap pour la mise en page
                        - Les classes .d-flex, .justify-content-end, .btn, .btn-primary structurent le bouton
                    --}}
                    <div class="d-flex justify-content-end">
                        <x-primary-button class="btn btn-primary">
                            {{ __('Reset Password') }}
                        </x-primary-button>
                    </div>
                </form>
            </x-guest-layout>
        </div>
        {{-- 
            Scripts JavaScript
            - Inclut les fichiers JavaScript de Bootstrap et du projet
        --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets/js/scripts.js') }}"></script>
    </body>
</html>