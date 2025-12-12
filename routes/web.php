<?php

use App\Livewire\Shared\Register;
use App\Livewire\Shared\LoginPage;
use App\Livewire\Shared\ContactPage;
use App\Livewire\Shared\LandingPage;
use App\Livewire\Tutoring\Dashboard;
use App\Livewire\Tutoring\DemandeDetails;
use App\Livewire\Tutoring\MesDemandes;
use App\Livewire\Shared\ServicesPage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Shared\IntervenantHub;
use App\Livewire\Tutoring\TutorDetails;
use App\Livewire\Tutoring\BookingProcess;
use App\Livewire\Tutoring\ProfessorsList;
use App\Http\Controllers\Api\Auth\LoginController;


use App\Livewire\Shared\RegisterClientPage;
use App\Livewire\Shared\RegisterIntervenantPage;
use App\Livewire\PetKeeping\SearchService as PetKeepingService;
use App\Livewire\PetKeeping\PetKeeperRegistration;


use App\Http\Controllers\Api\Auth\RegisterController;



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

Route::prefix('pet-keeping')->group(function (){
    Route::get('search-service', PetKeepingService::class);
});

Route::prefix('pet-keeper')->group(function(){
    Route::get('inscription', PetKeeperRegistration::class);
});

//Route::middleware(['auth'])->group(function () {
    // Route::get('/tutoring/dashboard', Dashboard::class)->name('tutoring.dashboard');
// Tutoring routes (client side)
Route::get('/services/professors-list', ProfessorsList::class)->name('professors-list');
Route::get('/professeurs/{id}', TutorDetails::class)->name('professeurs.details');
Route::get('/reservation/{service}', BookingProcess::class)->name('reservation.create');


Route::middleware(['auth'])->group(function () {
    Route::get('/tutoring/dashboard', Dashboard::class)->name('tutoring.dashboard');
    Route::get('/intervenant/hub', IntervenantHub::class)->name('intervenant.hub');
    Route::get('/tutoring/demande/{id}', DemandeDetails::class)->name('tutoring.request.details');
    Route::get('/tutoring/requests', MesDemandes::class)->name('tutoring.requests');
});

