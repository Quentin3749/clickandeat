<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    <style>
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }
        .page-title {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .form-control {
            max-width: 100%;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-5">
            <a class="navbar-brand" href="#!">Inscription</a>
        </div>
    </nav>

    <div class="container px-4 px-lg-5">
        <div class="form-container">
            <h2 class="page-title">Formulaire d'inscription</h2>

            <form method="POST" action="{{ route('register') }}" class="mt-4">
                @csrf
                <div class="mb-3">
                    <x-input-label for="name" :value="__('Name')" class="form-label" />
                    <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="text-danger mt-2" />
                </div>
                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email')" class="form-label" />
                    <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="text-danger mt-2" />
                </div>

                <div class="mb-3">
                    <x-input-label for="role" :value="__('Rôle')" class="form-label" />
                    <select name="role" id="role" class="form-control" required>
                        <option value="">Sélectionnez un rôle</option>
                        <option value="client">Client</option>
                        <option value="restaurateur">Restaurateur</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="text-danger mt-2" />
                </div>

                <!-- Champ caché pour s'assurer que le rôle est envoyé -->
                <input type="hidden" name="_role_submitted" value="1">

                <div class="mb-3">
                    <x-input-label for="password" :value="__('Password')" class="form-label" />
                    <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="text-danger mt-2" />
                </div>
                <div class="mb-3">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="form-label" />
                    <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger mt-2" />
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        {{ __('Already registered?') }}
                    </a>
                    <x-primary-button class="btn btn-primary">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>
</html>