<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - ClickAndEat</title>
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
            max-width: 450px;
            animation: fadeInDown 0.7s;
        }
        .dashboard-title {
            font-family: 'Poppins', sans-serif;
            color: #2563eb;
            font-weight: 700;
            letter-spacing: 1px;
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
            <h2 class="dashboard-title mb-4 text-center"><i class="fa fa-key me-2"></i>Mot de passe oublié</h2>
            <p class="text-center text-muted mb-4">Entrez votre adresse e-mail pour recevoir un lien de réinitialisation.</p>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input id="email" class="form-control" type="email" name="email" required autofocus>
                    @error('email')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">Envoyer le lien</button>
            </form>
            <div class="text-center mt-3">
                <a href="/login" class="text-decoration-none text-primary"><i class="fa fa-arrow-left me-1"></i>Retour à la connexion</a>
            </div>
        </div>
    </div>
    <footer class="text-center text-muted py-4">
        &copy; 2025 ClickAndEat. Tous droits réservés.
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
