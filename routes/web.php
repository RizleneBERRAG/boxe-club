<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Accueil
Route::get('/', fn () => view('pages.home'))->name('home');

// Pages vitrines
Route::view('/le-club', 'pages.club')->name('club');
Route::view('/cours-horaires', 'pages.courses')->name('courses');
Route::view('/tarifs', 'pages.pricing')->name('pricing');
Route::view('/actualites', 'pages.news')->name('news.index');

Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/mentions-legales', 'pages.legal')->name('legal');

// Formulaire de contact (POST)
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

// Boutique publique (affiche les produits)
Route::get('/boutique', [ShopController::class, 'index'])->name('boutique');

// Réservation produit
Route::post('/reservation', [ShopController::class, 'reserve'])->name('reservation.submit');

// Inscription (multi-étapes)
Route::prefix('inscription')->group(function () {
    Route::get('/', [EnrollmentController::class, 'step1'])->name('enroll.step1');
    Route::post('/', [EnrollmentController::class, 'postStep1'])->name('enroll.postStep1');

    Route::get('/paiement', [EnrollmentController::class, 'step2'])->name('enroll.step2');
    Route::post('/paiement', [EnrollmentController::class, 'postStep2'])->name('enroll.postStep2');

    Route::get('/attestation', [EnrollmentController::class, 'step3'])->name('enroll.step3');
});


// ======================= ADMIN =======================

Route::prefix('admin')->name('admin.')->group(function () {

    // --- Auth admin (publique) ---
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

    // logout admin
    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->middleware('admin')
        ->name('logout');

    // --- Zone protégée ---
    Route::middleware('admin')->group(function () {

        // Dashboard principal
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Gestion des produits boutique
        Route::resource('products', ProductController::class)->except(['show']);

        // (plus tard) : suivis paiements, dossiers, etc.
        // Route::get('/enrollments', [...])->name('enrollments.index');
        // Route::get('/payments', [...])->name('payments.index');
    });
});
