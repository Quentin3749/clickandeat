<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations - ClickAndEat</title>
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
        .reservation-card {
            border-radius: 1rem;
            box-shadow: 0 2px 12px rgba(44,62,80,0.08);
            background: #f8fafc;
            margin-bottom: 1.5rem;
            transition: transform 0.15s;
        }
        .reservation-card:hover {
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
            <h2 class="dashboard-title mb-4 text-center"><i class="fa fa-calendar-check me-2"></i>Mes Réservations</h2>
            <div class="row">
                @forelse($reservations as $reservation)
                    <div class="col-md-4">
                        <div class="reservation-card p-4 h-100">
                            <h5 class="fw-bold mb-2">{{ $reservation->restaurant->name ?? 'N/A' }}</h5>
                            <p class="mb-1 text-muted"><strong>Date :</strong> {{ $reservation->date }}</p>
                            <p class="mb-2"><strong>Personnes :</strong> {{ $reservation->guests }}</p>
                            <form action="{{ route('annuler-reservation', $reservation->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-danger btn-sm mt-2" type="submit"><i class="fa fa-times"></i> Annuler</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">Aucune réservation trouvée.</div>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('reserver') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Nouvelle réservation</a>
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
