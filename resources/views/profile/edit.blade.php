<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - ClickAndEat</title>
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
        .section-title {
            color: #2563eb;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .btn-primary, .btn-danger, .btn-outline-primary {
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 0.5rem;
            padding: 0.5rem 1.5rem;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(44,62,80,0.09);
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        }
        .btn-primary {
            background: #2563eb;
            border: none;
            color: #fff;
        }
        .btn-primary:hover {
            background: #1d4ed8;
            color: #fff;
            box-shadow: 0 4px 16px rgba(37,99,235,0.12);
        }
        .btn-outline-primary {
            border: 2px solid #2563eb;
            color: #2563eb;
            background: transparent;
        }
        .btn-outline-primary:hover {
            background: #2563eb;
            color: #fff;
        }
        .btn-danger {
            background: #e11d48;
            border: none;
            color: #fff;
        }
        .btn-danger:hover {
            background: #be123c;
            color: #fff;
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
            <span class="text-white ms-auto">Mon Profil</span>
        </div>
    </nav>
    <div class="container dashboard-container">
        <div class="dashboard-card animate__animated animate__fadeInDown">
            <a href="/client/dashboard" class="btn btn-outline-primary back-btn"><i class="fa fa-arrow-left me-2"></i>Retour au tableau de bord</a>
            <h2 class="dashboard-title mb-4 text-center"><i class="fa fa-user me-2"></i>Mon Profil</h2>
            <div class="mb-4">
                @include('profile.partials.update-profile-information-form')
            </div>
            <div class="mb-4">
                @include('profile.partials.update-password-form')
            </div>
            <div>
                @include('profile.partials.delete-user-form')
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
