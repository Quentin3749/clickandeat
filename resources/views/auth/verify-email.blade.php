<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Verify Email</title>
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
            - Les classes .container, .px-4, .px-lg-5 structurent le contenu
        --}}
        <div class="container px-4 px-lg-5">
            {{-- 
                Layout invité
                - Utilise la directive @extends pour étendre le layout invité
            --}}
            <x-guest-layout>
                {{-- 
                    Message de vérification d'adresse e-mail
                    - Utilise la directive @if pour afficher le message de vérification
                --}}
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                {{-- 
                    Formulaire de réenvoi de l'e-mail de vérification
                    - Utilise la directive @csrf pour générer le token CSRF
                --}}
                <div class="mt-4 d-flex justify-content-between">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <div>
                            <x-primary-button class="btn btn-primary">
                                {{ __('Resend Verification Email') }}
                            </x-primary-button>
                        </div>
                    </form>
                    {{-- 
                        Formulaire de déconnexion
                        - Utilise la directive @csrf pour générer le token CSRF
                    --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </x-guest-layout>
        </div>
        {{-- 
            Scripts
            - Utilise la directive @asset pour charger les scripts
        --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets/js/scripts.js') }}"></script>
    </body>
</html>
