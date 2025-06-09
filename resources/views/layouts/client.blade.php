<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Client - ClickAndEat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8fafc; }
        .sidebar {
            min-height: 100vh;
            background: #2d3748;
            color: #fff;
        }
        .sidebar .nav-link {
            color: #fff;
            font-weight: 500;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: #4fd1c5;
            color: #2d3748 !important;
        }
        .client-header {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .client-footer {
            background: #2d3748;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
            margin-top: 3rem;
        }
        @media (max-width: 991.98px) {
            .sidebar { min-height: auto; }
        }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <nav class="sidebar d-flex flex-column flex-shrink-0 p-3" style="width: 250px;">
        <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4 fw-bold"><i class="fa-solid fa-utensils me-2"></i>ClickAndEat</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item"><a href="/dashboard/client" class="nav-link @if(request()->is('dashboard/client')) active @endif"><i class="fa fa-home me-2"></i>Accueil</a></li>
            <li><a href="/restaurants" class="nav-link @if(request()->is('restaurants')) active @endif"><i class="fa fa-store me-2"></i>Restaurants</a></li>
            <li><a href="#" class="nav-link"><i class="fa fa-calendar-check me-2"></i>Mes réservations</a></li>
            <li><a href="#" class="nav-link"><i class="fa fa-user me-2"></i>Profil</a></li>
            <li><a href="#" class="nav-link"><i class="fa fa-sign-out-alt me-2"></i>Déconnexion</a></li>
        </ul>
    </nav>
    <!-- Main content -->
    <div class="flex-grow-1">
        <header class="client-header">
            <div>
                <span class="fw-bold">Espace Client</span>
            </div>
            <div>
                <img src="https://img.icons8.com/color/48/000000/user-male-circle.png" alt="Avatar" class="rounded-circle" style="width:48px;height:48px;">
                <span class="ms-2 fw-semibold">{{ Auth::user()->name ?? 'Client' }}</span>
            </div>
        </header>
        <main class="p-4">
            @yield('content')
        </main>
        <footer class="client-footer">
            &copy; 2025 ClickAndEat. Tous droits réservés.
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
