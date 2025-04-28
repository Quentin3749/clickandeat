<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Click & Eat - Bienvenue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton:wght@400&display=swap" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: url('{{ asset('images/bg-chalk.jpg') }}') center/cover no-repeat, #222;
            color: #fff;
        }
        .hero {
            padding: 60px 0 40px 0;
            text-align: center;
        }
        .logo-circle {
            width: 100px;
            height: 100px;
            background: #222;
            border-radius: 50%;
            margin: 0 auto 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #bfa14a;
            box-shadow: 0 4px 24px rgba(0,0,0,0.18);
        }
        .logo-circle img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }
        .main-title {
            font-family: 'Anton', Impact, sans-serif;
            font-size: 4rem;
            color: #ffb52a;
            text-shadow: 3px 3px 0 #222, 6px 6px 0 #bfa14a;
            letter-spacing: 4px;
            margin-bottom: 0.2em;
        }
        .main-title span {
            color: #ffb52a;
            text-shadow: 2px 2px 0 #bfa14a;
        }
        .hero-text {
            font-size: 1.3rem;
            margin-bottom: 35px;
            color: #fffbe7;
            text-shadow: 1px 1px 0 #222;
        }
        .btn-main {
            background: #bfa14a;
            color: #fff;
            border: none;
            margin: 0 10px;
            padding: 12px 32px;
            font-size: 1.1rem;
            border-radius: 30px;
            transition: background 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.10);
        }
        .btn-main:hover {
            background: #a88e3d;
            color: #fff;
        }
        .chalk-illustr {
            position: absolute;
            z-index: 1;
            opacity: 0.18;
        }
        .chalk-top-left {
            top: 0; left: 0; width: 260px;
        }
        .chalk-top-right {
            top: 0; right: 0; width: 270px;
        }
        .chalk-bottom-left {
            bottom: 0; left: 0; width: 210px;
        }
        @media (max-width: 700px) {
            .main-title { font-size: 2.2rem; }
            .logo-circle { width: 70px; height: 70px; }
            .logo-circle img { width: 45px; height: 45px; }
        }
    </style>
</head>
<body>
    <!-- Illustrations de fond style "chalk" (optionnel, à placer dans /public/images/) -->
    <img src="{{ asset('images/chalk-meat.png') }}" class="chalk-illustr chalk-top-left" alt="Viande">
    <img src="{{ asset('images/chalk-potatoes.png') }}" class="chalk-illustr chalk-top-right" alt="Pommes de terre">
    <img src="{{ asset('images/chalk-pasta.png') }}" class="chalk-illustr chalk-bottom-left" alt="Pâtes">

    @if(Auth::check())
        <div style="margin: 20px; color: #fff;">
            Connecté en tant que : {{ Auth::user()->email }} (role : {{ Auth::user()->role }})
        </div>
        <form action="{{ route('logout') }}" method="POST" style="margin: 20px 0;">
            @csrf
            <button type="submit" class="btn btn-danger">Déconnexion</button>
        </form>
    @else
        <div style="margin: 20px; color: #fff;">Non connecté</div>
    @endif

    <div class="container hero position-relative" style="z-index:2;">
        <div class="logo-circle">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Click & Eat">
        </div>
        <div class="main-title">
            CLICK <span>&amp;</span> EAT
        </div>
        <div class="hero-text">
            Réservez, commandez, dégustez.<br>
            La plateforme qui connecte gourmets et restaurateurs !
        </div>
        <a href="{{ route('login') }}" class="btn btn-main">Se connecter</a>
        <a href="{{ route('register') }}" class="btn btn-main">S’inscrire</a>
        <div class="mt-4">
            <a href="{{ route('restaurants.index') }}" class="text-decoration-underline text-light">Découvrir les restaurants</a>
        </div>
    </div>
</body>
</html>
