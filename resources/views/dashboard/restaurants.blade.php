<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurants - ClickAndEat</title>
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
            max-width: 900px;
            animation: fadeInDown 0.7s;
        }
        .dashboard-title {
            font-family: 'Poppins', sans-serif;
            color: #2563eb;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .restaurant-card {
            border-radius: 1rem;
            box-shadow: 0 2px 12px rgba(44,62,80,0.08);
            background: #f8fafc;
            margin-bottom: 1.5rem;
            transition: transform 0.15s;
        }
        .restaurant-card:hover {
            transform: translateY(-5px) scale(1.03);
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
        </div>
    </nav>
    <div class="container dashboard-container">
        <div class="dashboard-card animate__animated animate__fadeInDown">
            <h2 class="dashboard-title mb-4 text-center"><i class="fa fa-store me-2"></i>Liste des restaurants</h2>
            <div class="row">
                @forelse($restaurants as $restaurant)
                    <div class="col-md-4">
                        <div class="restaurant-card p-4 h-100">
                            <h5 class="fw-bold mb-2">{{ $restaurant->name }}</h5>
                            <p class="mb-2"><strong>Adresse :</strong> {{ $restaurant->address ?? 'Non renseignée' }}</p>
                            <a href="{{ route('restaurants.show', $restaurant->id) }}" class="btn btn-primary mt-2 w-100">
                                Voir le site du restaurant & commander
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">Aucun restaurant disponible pour le moment.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <footer class="text-center text-muted py-4">
        &copy; 2025 ClickAndEat. Tous droits réservés.
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>
</html>
