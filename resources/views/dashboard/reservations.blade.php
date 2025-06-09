<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations - ClickAndEat</title>
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
        .reservation-list {
            margin-top: 2rem;
        }
        .reservation-item {
            border-radius: 1rem;
            box-shadow: 0 2px 12px rgba(44,62,80,0.08);
            background: #f8fafc;
            margin-bottom: 1.5rem;
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
        }
        .reservation-item strong {
            color: #2563eb;
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
            <h2 class="dashboard-title mb-4 text-center"><i class="fa fa-calendar-check me-2"></i>Mes Réservations</h2>
            <div class="reservation-list">
                @forelse($reservations as $reservation)
                    <div class="reservation-item">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <strong>{{ $reservation->restaurant->name ?? 'Restaurant inconnu' }}</strong>
                                <div class="text-muted small">{{ $reservation->date ?? '-' }} à {{ $reservation->time ?? '-' }}</div>
                                <div class="text-muted small">Adresse : {{ $reservation->restaurant->address ?? '-' }}</div>
                            </div>
                            <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-primary btn-sm px-4 mt-2 mt-md-0">Détails</a>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info text-center">Aucune réservation pour le moment.</div>
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
