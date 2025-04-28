<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $restaurant->name }} - Restaurant</title>
    <meta name="description" content="{{ $restaurant->description ?? '' }}">
    <!-- Favicons -->
    <link href="{{ asset('yummy-red-1.0.0/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('yummy-red-1.0.0/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('yummy-red-1.0.0/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('yummy-red-1.0.0/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('yummy-red-1.0.0/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('yummy-red-1.0.0/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('yummy-red-1.0.0/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="{{ asset('yummy-red-1.0.0/assets/css/main.css') }}" rel="stylesheet">
</head>
<body class="index-page">
    @php
        // Pour utiliser les sections dynamiques du restaurant
        $categories = $restaurant->categories ?? collect();
    @endphp
    <!-- Header -->
    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="/" class="logo d-flex align-items-center me-auto me-xl-0">
                <h1 class="sitename">{{ $restaurant->name }}</h1>
                <span>.</span>
            </a>
            @auth
                @if(Route::has('restaurateur.dashboard') && auth()->user()->isRestaurateur() && isset($restaurant->user_id) && auth()->id() == $restaurant->user_id)
                    <a href="{{ route('restaurateur.dashboard') }}" class="btn btn-outline-primary ms-3 d-none d-md-inline">Retour espace restaurateur</a>
                    <a href="{{ route('restaurateur.restaurant.show', $restaurant->id) }}" class="btn btn-outline-warning ms-3 d-none d-md-inline">Retour à la gestion du restaurant</a>
                @endif
            @endauth
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Accueil</a></li>
                    <li><a href="#about">À propos</a></li>
                    <li><a href="#menu">Menu</a></li>
                    <li><a href="#gallery">Galerie</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </div>
    </header>
    <!-- Main -->
    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section light-background">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2 data-aos="fade-up">Bienvenue chez <span>{{ $restaurant->name }}</span></h2>
                        <p data-aos="fade-up" data-aos-delay="100">{{ $restaurant->description ?? 'Découvrez notre établissement et nos spécialités culinaires.' }}</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Section -->
        <section id="about" class="about section">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-6">
                        <img src="{{ asset('yummy-red-1.0.0/assets/img/about.jpg') }}" class="img-fluid" alt="about">
                    </div>
                    <div class="col-lg-6 d-flex flex-column justify-content-center">
                        <h3>À propos</h3>
                        <p>{{ $restaurant->about ?? 'Bienvenue dans notre restaurant, où chaque plat est une expérience.' }}</p>
                        <ul>
                            <li><i class="bi bi-check-circle"></i> Catégories :
                                @if($categories->count())
                                    {{ $categories->pluck('name')->join(', ') }}
                                @else
                                    Aucune catégorie associée.
                                @endif
                            </li>
                            <li><i class="bi bi-clock"></i> Horaires : {{ $restaurant->schedules ?? 'Non renseigné' }}</li>
                            <li><i class="bi bi-geo-alt"></i> Adresse : {{ $restaurant->address ?? 'Non renseignée' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- Menu Section -->
        <section id="menu" class="menu section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Notre Menu</h2>
                <p><span>Découvrez</span> <span class="description-title">notre carte</span></p>
            </div>
            <div class="container">
                @php
                    $items = $restaurant->items()->where('is_available', true)->get();
                @endphp
                @if($items->count())
                    <div class="row">
                        @foreach($items as $item)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="{{ asset('yummy-red-1.0.0/assets/img/menu/menu-item-1.png') }}" class="card-img-top" alt="{{ $item->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->name }}</h5>
                                        <p class="card-text">{{ $item->description }}</p>
                                        <span class="badge bg-danger">{{ $item->price }} €</span>
                                        @auth
                                            @if(auth()->user()->isClient())
                                                <form method="POST" action="{{ route('cart.add', $item->id) }}" class="mt-2">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">Commander</button>
                                                </form>
                                            @endif
                                        @endauth
                                        <!-- Bouton de suppression du plat pour restaurateur uniquement -->
                                        @auth
                                            @if(auth()->user()->isRestaurateur() && isset($restaurant->user_id) && auth()->id() == $restaurant->user_id)
                                                <form method="POST" action="{{ route('restaurateur.restaurant.deleteitem', ['id' => $restaurant->id, 'item' => $item->id]) }}" onsubmit="return confirm('Supprimer ce plat ?');">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-sm mt-2">Supprimer</button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Menu non disponible pour le moment.</p>
                @endif
            </div>
        </section>
        <!-- Galerie Section -->
        <section id="gallery" class="gallery section light-background">
            <div class="container section-title" data-aos="fade-up">
                <h2>Galerie</h2>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4"><img src="{{ asset('yummy-red-1.0.0/assets/img/gallery/gallery-1.jpg') }}" class="img-fluid rounded" alt="Gal 1"></div>
                    <div class="col-md-4 mb-4"><img src="{{ asset('yummy-red-1.0.0/assets/img/gallery/gallery-2.jpg') }}" class="img-fluid rounded" alt="Gal 2"></div>
                    <div class="col-md-4 mb-4"><img src="{{ asset('yummy-red-1.0.0/assets/img/gallery/gallery-3.jpg') }}" class="img-fluid rounded" alt="Gal 3"></div>
                </div>
            </div>
        </section>
        <!-- Contact Section -->
        <section id="contact" class="contact section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Contact</h2>
                <p>Pour toute demande ou réservation, contactez-nous.</p>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-unstyled">
                            <li><i class="bi bi-telephone"></i> Téléphone : {{ $restaurant->phone ?? 'Non renseigné' }}</li>
                            <li><i class="bi bi-envelope"></i> Email : {{ $restaurant->email ?? 'Non renseigné' }}</li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <div>
                            {!! QrCode::size(120)->generate(route('restaurants.menu', $restaurant->id)) !!}
                        </div>
                        <small class="text-muted">Scannez pour accéder au menu de ce restaurant.</small>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <footer id="footer" class="footer dark-background">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} {{ $restaurant->name }}. Tous droits réservés.</p>
        </div>
    </footer>
    <!-- Vendor JS Files -->
    <script src="{{ asset('yummy-red-1.0.0/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('yummy-red-1.0.0/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('yummy-red-1.0.0/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('yummy-red-1.0.0/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('yummy-red-1.0.0/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('yummy-red-1.0.0/assets/vendor/php-email-form/validate.js') }}"></script>
    <!-- Main JS File -->
    <script src="{{ asset('yummy-red-1.0.0/assets/js/main.js') }}"></script>
</body>
</html>