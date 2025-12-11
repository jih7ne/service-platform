<?php

use App\Livewire\Shared\LandingPage;
use App\Livewire\Shared\ServicesPage;
use App\Livewire\Shared\ContactPage;
use App\Livewire\Shared\LoginPage;
use App\Livewire\Shared\Register;
use App\Livewire\Shared\RegisterClientPage;
use App\Livewire\Shared\RegisterIntervenantPage;

use App\Livewire\Tutoring\Dashboard;
use App\Livewire\Shared\IntervenantHub;

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Support\Facades\Route;


Route::get('/', LandingPage::class);
Route::get('/services', ServicesPage::class);
Route::get('/contact', ContactPage::class);
Route::get('/connexion', LoginPage::class);
Route::get('/inscription', Register::class);
Route::get('/inscriptionIntervenant', RegisterIntervenantPage::class);
Route::get('/inscriptionClient', RegisterClientPage::class);

// Client registration POST route
Route::post('/register-client', [RegisterController::class, 'store'])->name('register.store');
Route::post('/connexion', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
Route::get('/inscriptionProfesseur', \App\Livewire\Tutoring\RegisterProfesseur::class);


Route::middleware(['auth'])->group(function () {
    Route::get('/tutoring/dashboard', Dashboard::class)->name('tutoring.dashboard');
    Route::get('/intervenant/hub', IntervenantHub::class)->name('intervenant.hub');
});

