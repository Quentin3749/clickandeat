<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
        <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="navbar-brand" href="#!">connection</a>
                
                
            </div>
        </nav>
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-md-6">
                <h1 class="text-center">click'n eat</h1>
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <x-input-label for="email" :value="__('Email')" class="form-label" />
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="text-danger mt-2" />
                    </div>
                    <div class="mb-3">
                        <x-input-label for="password" :value="__('Password')" class="form-label" />
                        <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="text-danger mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="remember_me" class="form-check-label">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                        <x-primary-button class="btn btn-primary">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets/js/scripts.js') }}"></script>
    </body>
</html>