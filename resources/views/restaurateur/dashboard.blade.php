<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Restaurateur - ClickAndEat</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        body {
            background: linear-gradient(120deg, #fbbf24 0%, #f87171 100%);
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
            background: #fffbe9;
            border-radius: 2rem;
            box-shadow: 0 8px 40px rgba(251,191,36,0.10);
            padding: 2.5rem 2rem 2rem 2rem;
            margin-bottom: 2rem;
            width: 100%;
            max-width: 700px;
            animation: fadeInDown 0.8s;
        }
        .dashboard-title {
            font-family: 'Poppins', sans-serif;
            color: #f59e42;
            font-weight: 800;
            letter-spacing: 1px;
            text-shadow: 1px 1px 0 #fff3cd;
        }
        .dashboard-subtitle {
            color: #ef4444;
            font-size: 1.1rem;
            font-weight: 500;
        }
        .quick-links {
            margin-top: 2rem;
        }
        .quick-link-card {
            border-radius: 1.2rem;
            box-shadow: 0 2px 12px rgba(251,191,36,0.08);
            background: #fff3cd;
            transition: transform 0.15s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }
        .quick-link-card .btn {
            margin-top: auto;
        }
        .quick-link-card:hover {
            transform: translateY(-5px) scale(1.03);
        }
        .quick-link-icon {
            font-size: 2.5rem;
            margin-bottom: 0.7rem;
        }
        .btn-orange {
            background: #f59e42;
            border: none;
            color: #fff;
        }
        .btn-orange:hover {
            background: #ea580c;
            color: #fff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: #f59e42;">
        <div class="container px-5">
            <a class="navbar-brand fw-bold" href="/">ClickAndEat</a>
            <span class="text-white ms-auto">Espace Restaurateur</span>
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
            <!--<h2 class="dashboard-title mb-2 text-center"><i class="fa fa-utensils me-2"></i>Dashboard Restaurateur</h2>-->
            <div class="dashboard-subtitle text-center mb-4">Bienvenue dans votre espace restaurateur !</div>
            <div class="text-center mb-4">
                <a href="{{ route('restaurateur.restaurant.create') }}" class="btn btn-orange fw-bold"><i class="fa fa-plus me-1"></i>Créer un restaurant</a>
            </div>
            <div class="row quick-links justify-content-center text-center g-4">
                <div class="col-md-3">
                    <div class="p-4 quick-link-card h-100">
                        <div class="quick-link-icon text-warning"><i class="fa fa-clipboard-list"></i></div>
                        <h5 class="fw-bold">Réservations & Commandes</h5>
                        <p class="text-muted">Gérez toutes les réservations et commandes de vos clients.</p>
                        <a href="{{ route('restaurateur.commandes') }}" class="btn btn-orange btn-sm px-4">Voir</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 quick-link-card h-100">
                        <div class="quick-link-icon text-danger"><i class="fa fa-store"></i></div>
                        <h5 class="fw-bold">Mes Restaurants</h5>
                        <p class="text-muted">Modifiez les infos et le menu de vos établissements.</p>
                        <a href="{{ route('restaurateur.restaurant.list') }}" class="btn btn-orange btn-sm px-4">Voir</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 quick-link-card h-100">
                        <div class="quick-link-icon text-success"><i class="fa fa-history"></i></div>
                        <h5 class="fw-bold">Historique</h5>
                        <p class="text-muted">Consultez l'historique de vos réservations et commandes.</p>
                        <a href="{{ route('orders.history') }}" class="btn btn-orange btn-sm px-4">Voir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center text-muted py-4">
        &copy; 2025 ClickAndEat. Tous droits réservés.
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
