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
            max-width: 900px;
            animation: fadeInDown 0.7s;
        }
        .dashboard-title {
            font-family: 'Poppins', sans-serif;
            color: #2563eb;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .table {
            background: #f8fafc;
            border-radius: 1rem;
            overflow: hidden;
        }
        .table th {
            background: #2563eb;
            color: #fff;
            font-weight: 600;
            border: none;
        }
        .table td {
            vertical-align: middle;
        }
        .btn-danger {
            background: #e11d48;
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 0.5rem;
        }
        .btn-danger:hover {
            background: #be123c;
        }
        .back-btn {
            margin-bottom: 1.5rem;
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
            <a href="/client/dashboard" class="btn btn-outline-primary back-btn"><i class="fa fa-arrow-left me-2"></i>Retour au tableau de bord</a>
            <h2 class="dashboard-title mb-4 text-center"><i class="fa fa-calendar-check me-2"></i>Mes Réservations</h2>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Restaurant</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Couverts</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->restaurant->name }}</td>
                                <td>{{ $reservation->date }}</td>
                                <td>{{ $reservation->time }}</td>
                                <td>{{ $reservation->guests }}</td>
                                <td>{{ ucfirst($reservation->status) }}</td>
                                <td>
                                    @if($reservation->status === 'pending')
                                    <form method="POST" action="{{ route('reservations.cancel', $reservation) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Annuler</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Aucune réservation trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
