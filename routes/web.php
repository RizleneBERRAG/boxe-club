<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\AdminOnly;
use App\Http\Controllers\EnrollmentDocsController;
use App\Http\Controllers\Admin\EnrollmentAdminController;
use App\Http\Controllers\StripeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =======================
// Pages publiques
// =======================

// Accueil
Route::get('/', fn() => view('pages.home'))->name('home');

// Pages vitrines
Route::view('/le-club', 'pages.club')->name('club');
Route::view('/cours-horaires', 'pages.courses')->name('courses');
Route::view('/tarifs', 'pages.pricing')->name('pricing');
Route::view('/actualites', 'pages.news')->name('news.index');

Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/mentions-legales', 'pages.legal')->name('legal');

// Contact
Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.submit');

// =======================
// Boutique publique
// =======================
Route::get('/boutique', [ShopController::class, 'index'])
    ->name('boutique');

Route::post('/reservation', [ShopController::class, 'reserve'])
    ->name('reservation.submit');

// =======================
// Inscription (dossier / paiement / attestation)
// =======================
Route::prefix('inscription')->group(function () {

    Route::get('/', [EnrollmentController::class, 'step1'])
        ->name('enroll.step1');

    Route::post('/', [EnrollmentController::class, 'postStep1'])
        ->name('enroll.postStep1');

    Route::get('/paiement', [EnrollmentController::class, 'step2'])
        ->name('enroll.step2');

    Route::post('/paiement', [EnrollmentController::class, 'postStep2'])
        ->name('enroll.postStep2');

    Route::get('/attestation', [EnrollmentController::class, 'step3'])
        ->name('enroll.step3');
});

// =======================
// ADMIN
// =======================

// Auth admin (publique)
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Zone admin protégée
Route::prefix('admin')
    ->middleware(AdminOnly::class)
    ->name('admin.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', ProductController::class)->except(['show']);

        // INSCRIPTIONS
        Route::get('/enrollments', [EnrollmentAdminController::class, 'index'])->name('enrollments.index');
        Route::get('/enrollments/{enrollment}', [EnrollmentAdminController::class, 'show'])->name('enrollments.show');

        // Actions
        Route::patch('/enrollments/{enrollment}/mark-paid', [EnrollmentAdminController::class, 'markPaid'])
            ->name('enrollments.markPaid');

        Route::patch('/enrollments/{enrollment}/mark-pending', [EnrollmentAdminController::class, 'markPending'])
            ->name('enrollments.markPending');
    });



// Paiement test
Route::get('/paiement-test', [StripeController::class, 'checkoutTest'])
    ->name('stripe.test');

// Pages de retour
Route::get('/paiement/succes', [StripeController::class, 'success'])
    ->name('stripe.success');

Route::get('/paiement/annule', [StripeController::class, 'cancel'])
    ->name('stripe.cancel');
