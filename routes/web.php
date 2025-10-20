<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Fichier unique et propre : accueil, pages vitrines, inscription (Step1→3),
| et contact. Pas de doublons ni de routes racine répétées.
|--------------------------------------------------------------------------
*/

// Accueil (page d’entrée du site)
Route::get('/', fn () => view('pages.home'))->name('home');

// Pages vitrines
Route::view('/le-club', 'pages.club')->name('club');
Route::view('/cours-horaires', 'pages.courses')->name('courses');
Route::view('/tarifs', 'pages.pricing')->name('pricing');
Route::view('/actualites', 'pages.news')->name('news.index');
Route::view('/galerie', 'pages.gallery')->name('gallery');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/mentions-legales', 'pages.legal')->name('legal');

// Formulaire de contact (POST)
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

// Inscription (multi-étapes)
Route::prefix('inscription')->group(function () {
    // Étape 1 — infos boxeur
    Route::get('/', [EnrollmentController::class, 'step1'])->name('enroll.step1');
    Route::post('/', [EnrollmentController::class, 'postStep1'])->name('enroll.postStep1');

    // Étape 2 — paiement
    Route::get('/paiement', [EnrollmentController::class, 'step2'])->name('enroll.step2');
    Route::post('/paiement', [EnrollmentController::class, 'postStep2'])->name('enroll.postStep2');

    // Étape 3 — attestation
    Route::get('/attestation', [EnrollmentController::class, 'step3'])->name('enroll.step3');
});
