<?php

use Illuminate\Support\Facades\Route;

// Auth Controllers
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;

// Shared Livewire Components
use App\Livewire\Shared\Register;
use App\Livewire\Shared\LoginPage;
use App\Livewire\Shared\ContactPage;
use App\Livewire\Shared\LandingPage;
use App\Livewire\Shared\ServicesPage;
use App\Livewire\Shared\IntervenantHub;
use App\Livewire\Shared\ProfilClient;
use App\Livewire\Shared\RegisterClientPage;
use App\Livewire\Shared\RegisterIntervenantPage;

// Tutoring Livewire Components
use App\Livewire\Tutoring\Dashboard;
use App\Livewire\Tutoring\MesDemandes;
use App\Livewire\Tutoring\TutorDetails;
use App\Livewire\Tutoring\BookingProcess;
use App\Livewire\Tutoring\DemandeDetails;
use App\Livewire\Tutoring\ProfessorsList;
use App\Livewire\Tutoring\RegisterProfesseur;

// Babysitter Livewire Components
use App\Livewire\Babysitter\ListeBabysitter;
use App\Livewire\Babysitter\BabysitterProfilePage;
use App\Livewire\Babysitter\BabysitterBooking;
use App\Livewire\Babysitter\BabysitterRegistration;
use App\Livewire\Babysitter\BabysitterRegistrationSuccess;
use App\Livewire\Babysitter\BabysitterDashboard;
use App\Livewire\Babysitter\BabysitterProfile;

// PetKeeping Livewire Components
use App\Livewire\PetKeeping\SearchService as PetKeepingService;
use App\Livewire\PetKeeping\PetkeeperBooking;
use App\Livewire\PetKeeping\PetKeeperProfile;
use App\Livewire\PetKeeping\PetKeeperDashboard;
use App\Livewire\PetKeeping\PetKeeperRegistration;
use App\Livewire\PetKeeperMissionDetails;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', LandingPage::class)->name('home');
Route::get('/services', ServicesPage::class)->name('services');
Route::get('/contact', ContactPage::class)->name('contact');
Route::get('/connexion', LoginPage::class)->name('login');
Route::get('/inscription', Register::class)->name('register');
Route::get('/inscriptionIntervenant', RegisterIntervenantPage::class)->name('register.intervenant');
Route::get('/inscriptionClient', RegisterClientPage::class)->name('register.client');
Route::get('/inscriptionProfesseur', RegisterProfesseur::class)->name('register.professeur');
Route::get('/inscriptionBabysitter', BabysitterRegistration::class)->name('inscription.babysitter');
Route::get('/babysitter-registration-success', BabysitterRegistrationSuccess::class)->name('babysitter-registration-success');

// Public Babysitter Routes
Route::get('/liste-babysitter', ListeBabysitter::class)->name('liste.babysitter');
Route::get('/babysitter-profile/{id}', BabysitterProfilePage::class)->name('babysitter.profile.page');
Route::get('/babysitter-booking/{id}', BabysitterBooking::class)->name('babysitter.booking');

// Public Tutoring Routes
Route::get('/services/professors-list', ProfessorsList::class)->name('professors-list');
Route::get('/professeurs/{id}', TutorDetails::class)->name('professeurs.details');
Route::get('/reservation/{service}', BookingProcess::class)->name('reservation.create');

// Auth Routes
Route::post('/register-client', [RegisterController::class, 'store'])->name('register.store');
Route::post('/connexion', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Profile
    Route::get('/profil', ProfilClient::class)->name('profile');
    
    // Intervenant Hub
    Route::get('/intervenant/hub', IntervenantHub::class)->name('intervenant.hub');
    
    // Tutoring
    Route::get('/tutoring/dashboard', Dashboard::class)->name('tutoring.dashboard');
    Route::get('/tutoring/requests', MesDemandes::class)->name('tutoring.requests');
    Route::get('/tutoring/demande/{id}', DemandeDetails::class)->name('tutoring.request.details');
    
    // Babysitter
    Route::get('/babysitter/dashboard', BabysitterDashboard::class)->name('babysitter.dashboard');
    Route::get('/babysitter/profile', BabysitterProfile::class)->name('babysitter.profile');
});

// Pet Keeping Routes (Client)
Route::prefix('pet-keeping')->name('petkeeping.')->group(function () {
    Route::get('search-service', PetKeepingService::class)->name('search');
    Route::get('book', PetkeeperBooking::class)->name('book');
});

// Pet Keeper Routes (Provider)
Route::prefix('pet-keeper')->name('petkeeper.')->group(function () {
    Route::get('inscription', PetKeeperRegistration::class)->name('inscription');
    Route::get('profile', PetKeeperProfile::class)->name('profile');
    Route::get('dashboard', PetKeeperDashboard::class)->name('dashboard');
    Route::get('mission/{id}', PetKeeperMissionDetails::class)->name('mission.details');
});