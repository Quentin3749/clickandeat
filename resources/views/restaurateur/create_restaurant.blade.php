<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Restaurant - ClickAndEat</title>
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
            max-width: 500px;
            animation: fadeInDown 0.8s;
        }
        .dashboard-title {
            font-family: 'Poppins', sans-serif;
            color: #f59e42;
            font-weight: 800;
            letter-spacing: 1px;
            text-shadow: 1px 1px 0 #fff3cd;
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
        </div>
    </nav>
    <div class="container dashboard-container">
        <div class="dashboard-card animate__animated animate__fadeInDown">
            <h2 class="dashboard-title mb-4 text-center"><i class="fa fa-store me-2"></i>Créer un Restaurant</h2>
            <form method="POST" action="{{ route('restaurateur.restaurant.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du restaurant</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Adresse</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="mb-3">
                    <label for="cuisine_type" class="form-label">Type de cuisine</label>
                    <input type="text" class="form-control" id="cuisine_type" name="cuisine_type" required>
                </div>
                <div class="mb-3">
                    <label for="price_range" class="form-label">Gamme de prix</label>
                    <select class="form-select" id="price_range" name="price_range">
                        <option value="€">€</option>
                        <option value="€€">€€</option>
                        <option value="€€€">€€€</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-orange w-100">Créer</button>
            </form>
        </div>
    </div>
    <footer class="text-center text-muted py-4">
        &copy; 2025 ClickAndEat. Tous droits réservés.
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
