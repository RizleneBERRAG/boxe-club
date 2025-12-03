<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\AdminOnly;
use App\Http\Controllers\StripeController;

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

// Formulaire de contact
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

// Boutique publique
Route::get('/boutique', [ShopController::class, 'index'])->name('boutique');
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

// --- Auth admin (PUBLIQUE, pas de middleware) ---
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.submit');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');

// --- Zone protégée admin ---
Route::prefix('admin')
    ->middleware(AdminOnly::class)
    ->name('admin.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');  // => route('admin.dashboard')

        Route::resource('products', ProductController::class)
            ->except(['show']);
    });



// Paiement test
Route::get('/paiement-test', [StripeController::class, 'checkoutTest'])
    ->name('stripe.test');

// Pages de retour
Route::get('/paiement/succes', [StripeController::class, 'success'])
    ->name('stripe.success');

Route::get('/paiement/annule', [StripeController::class, 'cancel'])
    ->name('stripe.cancel');


// sous haute tension

Route::get('/sous-haute-tension', function () {
    return view('gala.sous-haute-tension');
})->name('gala.sous-haute-tension');
