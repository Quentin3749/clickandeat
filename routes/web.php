<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RestaurantsController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RestaurantBookingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;
use App\Models\Restaurant;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;

// ---------------------------------------------
// Fichier de routes web principal de l'application
// Définit toutes les routes accessibles via le navigateur (interface utilisateur)
// ---------------------------------------------

// Routes pour la page d'accueil (accueil du site)
Route::get('/', function (\Illuminate\Http\Request $request) {
    // Prépare la requête pour filtrer les restaurants selon les paramètres reçus
    $query = \App\Models\Restaurant::query();
    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }
    if ($request->filled('cuisine_type')) {
        $query->where('cuisine_type', $request->cuisine_type);
    }
    if ($request->filled('price_range')) {
        $query->where('price_range', $request->price_range);
    }
    $restaurants = $query->get();
    $cuisineTypes = \App\Models\Restaurant::select('cuisine_type')->distinct()->pluck('cuisine_type')->filter();
    $priceRanges = \App\Models\Restaurant::select('price_range')->distinct()->pluck('price_range')->filter();
    $orders = null;
    // Si l'utilisateur est connecté, récupère ses commandes
    if (auth()->check()) {
        $orders = \App\Models\Order::with('restaurant')->where('user_id', auth()->id())->orderByDesc('created_at')->get();
    }
    // Affiche la vue d'accueil avec les données nécessaires
    return view('welcome', compact('restaurants', 'cuisineTypes', 'priceRanges', 'orders'));
});

// Routes d'authentification personnalisées
Route::middleware('guest')->group(function () {
    // Inscription
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    // Connexion
    Route::get('/login', [App\Http\Controllers\Auth\CustomAuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\CustomAuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Routes pour les utilisateurs authentifiés (général)
Route::middleware(['auth', 'verified'])->group(function () {
    // Profil de l'utilisateur (accessible à tous les utilisateurs authentifiés)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route dashboard accessible à tout utilisateur connecté
    Route::middleware(['auth'])->get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Route pour afficher les notifications de l'utilisateur
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    // --- PANIER ET COMMANDE CLIENT ---
    Route::get('/panier', [CartController::class, 'show'])->name('cart.show');
    Route::post('/panier/ajouter/{item}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/panier/retirer/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/panier/valider/{restaurant}', [CartController::class, 'checkout'])->name('cart.checkout');

    // --- Commandes client ---
    Route::get('/mes-commandes', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/commandes/{id}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
});

// === PROTECTION DES ROUTES PAR ROLE ===

// Espace administrateur sécurisé
Route::middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Ajoute ici d'autres routes admin si besoin
});

// Routes admin pour gestion complète des utilisateurs, restaurants et commandes
Route::middleware(['auth', 'check.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('restaurants', App\Http\Controllers\Admin\RestaurantController::class);
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
    Route::post('users/{user}/associate-restaurant', [App\Http\Controllers\Admin\UserController::class, 'associateRestaurant'])->name('users.associateRestaurant');
    Route::get('users/{user}/orders', [App\Http\Controllers\Admin\UserController::class, 'orders'])->name('users.orders');
});

// Groupe sécurisé pour les restaurateurs
Route::middleware(['auth', 'check.restaurateur'])->group(function () {
    // Dashboard restaurateur (accès principal)
    Route::get('/restaurateur/dashboard', function() {
        return view('restaurateur.dashboard');
    })->name('restaurateur.dashboard');

    // Liste des restaurants du restaurateur
    Route::get('/restaurateur/mon-restaurant', [App\Http\Controllers\RestaurantsController::class, 'mesRestaurants'])->name('restaurateur.restaurant.list');
    Route::get('/restaurateur/mon-restaurant/{id}', [App\Http\Controllers\RestaurantsController::class, 'showRestaurateur'])->name('restaurateur.restaurant.show');
    Route::get('/restaurateur/mon-restaurant/{id}/edit', [App\Http\Controllers\RestaurantsController::class, 'editRestaurateur'])->name('restaurateur.restaurant.edit');
    Route::put('/restaurateur/mon-restaurant/{id}', [App\Http\Controllers\RestaurantsController::class, 'updateRestaurateur'])->name('restaurateur.restaurant.update');
    Route::delete('/restaurateur/mon-restaurant/{id}', [App\Http\Controllers\RestaurantsController::class, 'destroyRestaurateur'])->name('restaurateur.restaurant.destroy');

    // Ajout et suppression de plats
    Route::get('/restaurateur/mon-restaurant/{id}/add-item', [App\Http\Controllers\RestaurantsController::class, 'addItemForm'])->name('restaurateur.restaurant.additem');
    Route::post('/restaurateur/mon-restaurant/{id}/add-item', [App\Http\Controllers\RestaurantsController::class, 'storeItem'])->name('restaurateur.restaurant.storeitem');
    Route::delete('/restaurateur/mon-restaurant/{id}/delete-item/{item}', [App\Http\Controllers\RestaurantsController::class, 'deleteItem'])->name('restaurateur.restaurant.deleteitem');

    // Correction des plats pour qu'ils soient tous commandables (ajout d'un id si manquant)
    Route::get('/restaurateur/mon-restaurant/{id}/fix-menu-ids', [App\Http\Controllers\RestaurantsController::class, 'fixMenuIds'])->name('restaurateur.restaurant.fixmenuids');

    // Commandes restaurateur
    Route::get('/restaurateur/commandes', [\App\Http\Controllers\OrderController::class, 'index'])->name('restaurateur.commandes');
    Route::patch('/restaurateur/commandes/{id}/statut', [\App\Http\Controllers\OrderController::class, 'updateStatus'])->name('restaurateur.commandes.updateStatus');

    // Création de restaurant
    Route::get('/restaurateur/restaurant/creer', [App\Http\Controllers\RestaurantsController::class, 'create'])->name('restaurateur.restaurant.create');
    Route::post('/restaurateur/restaurant', [App\Http\Controllers\RestaurantsController::class, 'store'])->name('restaurateur.restaurant.store');
});

// Espace client sécurisé
Route::middleware(['auth', 'check.client'])->prefix('client')->group(function () {
    Route::get('/dashboard', function () {
        return view('client.dashboard');
    })->name('client.dashboard');
    Route::get('/panier', [App\Http\Controllers\CartController::class, 'show'])->name('client.cart');

    // Paiement Stripe
    Route::post('/paiement', [App\Http\Controllers\StripeController::class, 'checkout'])->name('stripe.checkout');
    Route::get('/paiement/success', [App\Http\Controllers\StripeController::class, 'success'])->name('stripe.success');
});

// Historique commandes (authentifié)
Route::middleware(['auth'])->group(function () {
    Route::get('/commandes/historique', [OrderController::class, 'history'])->name('orders.history');
    Route::patch('/commandes/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

Route::resource('categories', CategoryController::class);
Route::resource('restaurants', RestaurantsController::class);
Route::resource('items', ItemController::class);
Route::resource('orders', OrderController::class)->middleware('auth'); // Ajout de la route pour les commandes

// Route publique pour afficher un restaurant avec le template yummy
Route::get('/restaurant/{id}', [App\Http\Controllers\RestaurantsController::class, 'show']);

// Route pour afficher le menu d'un restaurant spécifique
Route::get('/restaurants/{restaurant}/menu', [RestaurantsController::class, 'showMenu'])->name('restaurants.menu');

// Routes pour la réservation de restaurants
Route::get('/restaurants/book', [RestaurantBookingController::class, 'index'])->name('restaurants.book');
Route::get('/restaurants/{restaurant}/book', [RestaurantBookingController::class, 'showBookingForm'])->name('restaurants.book.form');

// === Génération de PDF pour commande ===
Route::middleware(['auth'])->get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');

// === Paiement Stripe ===
Route::middleware(['auth', 'check.client'])->group(function () {
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment/{order}/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/{order}/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
});

// === Politique de confidentialité ===
Route::view('/confidentialite', 'privacy')->name('privacy');

// Route pour afficher la liste des restaurants
Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');

// Route temporaire pour afficher la nouvelle page d'accueil client moderne
Route::get('/accueil-client-test', function () {
    return view('accueil_client');
});

// ===== NOUVEAU SYSTEME DE RESERVATION (PRODUCTION) =====
Route::middleware(['auth'])->group(function () {
    Route::get('/mes-reservations', [App\Http\Controllers\ReservationSimpleController::class, 'index'])->name('mes-reservations');
    Route::get('/reserver', [App\Http\Controllers\ReservationSimpleController::class, 'create'])->name('reserver');
    Route::post('/reserver', [App\Http\Controllers\ReservationSimpleController::class, 'store']);
    Route::post('/annuler-reservation/{id}', [App\Http\Controllers\ReservationSimpleController::class, 'cancel'])->name('annuler-reservation');
});

require __DIR__.'/auth.php';