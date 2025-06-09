<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Client - ClickAndEat</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        body {
            background: linear-gradient(135deg, #e0e7ff 0%, #f1f5f9 100%);
            min-height: 100vh;
        }
        .dashboard-container {
            min-height: 90vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .dashboard-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 6px 32px rgba(44,62,80,0.10);
            padding: 2.5rem 2rem 2rem 2rem;
            margin-bottom: 2rem;
            width: 100%;
            max-width: 650px;
            animation: fadeInDown 0.7s;
        }
        .dashboard-title {
            font-family: 'Poppins', sans-serif;
            color: #2563eb;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .quick-links {
            margin-top: 2rem;
        }
        .quick-link-card {
            border-radius: 1rem;
            box-shadow: 0 2px 12px rgba(44,62,80,0.08);
            transition: transform 0.15s;
            background: #f8fafc;
        }
        .quick-link-card:hover {
            transform: translateY(-5px) scale(1.03);
        }
        .quick-link-icon {
            font-size: 2.5rem;
            margin-bottom: 0.7rem;
        }
        .btn-primary {
            background: #2563eb;
            border: none;
        }
        .btn-primary:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-5">
            <a class="navbar-brand" href="/">ClickAndEat</a>
            <span class="text-white ms-auto">Espace Client</span>
            <a href="{{ route('client.cart') }}" class="btn btn-warning ms-3">
                <i class="fa fa-shopping-cart"></i> Mon Panier
                @php $cart = session('cart', []); @endphp
                @if(!empty($cart))
                    <span class="badge bg-danger">{{ array_sum($cart) }}</span>
                @endif
            </a>
            @auth
            <form action="{{ route('logout') }}" method="POST" class="ms-3">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Déconnexion</button>
            </form>
            @endauth
        </div>
    </nav>
    <div class="container dashboard-container">
        <div class="dashboard-card animate__animated animate__fadeInDown">
            <h2 class="dashboard-title mb-4 text-center"><i class="fa fa-user me-2"></i>Bienvenue, {{ Auth::user()->name }}</h2>
            <p class="text-center text-muted mb-4">Heureux de vous revoir sur ClickAndEat.</p>
            <div class="row quick-links text-center g-4">
                <div class="col-md-4">
                    <div class="p-4 quick-link-card h-100">
                        <div class="quick-link-icon text-primary"><i class="fa fa-calendar-check"></i></div>
                        <h5 class="fw-bold">Mes Réservations</h5>
                        <p class="text-muted">Consultez et gérez vos réservations en un clic.</p>
                        <a href="{{ route('mes-reservations') }}" class="btn btn-primary btn-sm px-4">Voir</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 quick-link-card h-100">
                        <div class="quick-link-icon text-success"><i class="fa fa-store"></i></div>
                        <h5 class="fw-bold">Restaurants</h5>
                        <p class="text-muted">Découvrez les restaurants partenaires.</p>
                        <a href="/restaurants" class="btn btn-primary btn-sm px-4">Voir</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 quick-link-card h-100">
                        <div class="quick-link-icon text-info"><i class="fa fa-user"></i></div>
                        <h5 class="fw-bold">Mon Profil</h5>
                        <p class="text-muted">Modifiez vos informations personnelles.</p>
                        <a href="/profile" class="btn btn-primary btn-sm px-4">Mon profil</a>
                    </div>
                </div>
            </div>
            <div class="alert alert-info mt-5 text-center shadow-sm">
                <i class="fa fa-bell me-2"></i> N'oubliez pas de consulter régulièrement vos notifications pour ne rien manquer !
            </div>
        </div>
    </div>
    <footer class="text-center text-muted py-4">
        &copy; 2025 ClickAndEat. Tous droits réservés.
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
