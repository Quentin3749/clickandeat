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

// Routes pour la page d'accueil (accueil du site)
Route::get('/', function () {
    return view('welcome');
});

// Routes d'authentification personnalisées
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
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

    // Dashboard par défaut (utilisé si aucun rôle spécifique n'est trouvé)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route pour afficher les notifications de l'utilisateur
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});

Route::middleware(['auth', 'check.admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Routes pour les clients
Route::middleware(['auth', 'check.client'])->prefix('client')->group(function () {
    Route::get('/dashboard', function () {
        return view('client.dashboard');
    })->name('client.dashboard');
});

// Routes pour les restaurateurs
Route::middleware(['auth', 'check.restaurateur'])->prefix('restaurateur')->group(function () {
    Route::get('/dashboard', function () {
        return view('restaurateur.dashboard');
    })->name('restaurateur.dashboard');

    // Route pour afficher la liste des commandes pour le restaurateur
    Route::get('/commandes', [OrderController::class, 'index'])->name('restaurateur.commandes.index');

    // Route pour mettre à jour le statut d'une commande par le restaurateur
    Route::patch('/commandes/{order}/status', [OrderController::class, 'updateStatus'])->name('restaurateur.commandes.updateStatus');
});

Route::resource('categories', CategoryController::class);
Route::resource('restaurants', RestaurantsController::class);
Route::resource('items', ItemController::class);
Route::resource('orders', OrderController::class)->middleware('auth'); // Ajout de la route pour les commandes

// Route pour afficher le menu d'un restaurant spécifique
Route::get('/restaurants/{restaurant}/menu', [RestaurantsController::class, 'showMenu'])->name('restaurants.menu');

// Routes pour la réservation de restaurants
Route::get('/restaurants/book', [RestaurantBookingController::class, 'index'])->name('restaurants.book');
Route::get('/restaurants/{restaurant}/book', [RestaurantBookingController::class, 'showBookingForm'])->name('restaurants.book.form');

require __DIR__.'/auth.php';