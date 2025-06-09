<head>
    {{--
        Inclusion de l'en-tête HTML commun
        - Contient les métadonnées, le titre, les liens CSS, et les scripts globaux
        - Utilisé dans les layouts principaux pour factoriser l'en-tête
    --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Click and Eat')</title>
    {{-- Lien vers Bootstrap ou Tailwind, et CSS personnalisé --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- Scripts JS globaux --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('styles')
</head>