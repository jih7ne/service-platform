<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Livewire - Shared
|--------------------------------------------------------------------------
*/
use App\Livewire\Shared\LandingPage;
use App\Livewire\Shared\ServicesPage;
use App\Livewire\Shared\ContactPage;
use App\Livewire\Shared\LoginPage;
use App\Livewire\Shared\Register;
use App\Livewire\Shared\RegisterClientPage;
use App\Livewire\Shared\RegisterIntervenantPage;
use App\Livewire\Shared\IntervenantHub;
use App\Livewire\Shared\ProfilClient;

/*
|--------------------------------------------------------------------------
| Auth Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Babysitter
|--------------------------------------------------------------------------
*/
use App\Livewire\Babysitter\ListeBabysitter;
use App\Livewire\Babysitter\BabysitterProfilePage;
use App\Livewire\Babysitter\BabysitterBooking;
use App\Livewire\Babysitter\BabysitterRegistration;
use App\Livewire\Babysitter\BabysitterRegistrationSuccess;
use App\Livewire\Babysitter\BabysitterDashboard;
use App\Livewire\Babysitter\BabysitterProfile;

/*
|--------------------------------------------------------------------------
| Pet Keeping
|--------------------------------------------------------------------------
*/
use App\Livewire\PetKeeping\SearchService as PetKeepingService;
use App\Livewire\PetKeeping\PetkeeperBooking;
use App\Livewire\PetKeeping\PetKeeperRegistration;
use App\Livewire\PetKeeping\PetKeeperProfile;
use App\Livewire\PetKeeping\PetKeeperDashboard;

/*
|--------------------------------------------------------------------------
| Tutoring
|--------------------------------------------------------------------------
*/
use App\Livewire\Tutoring\Dashboard;
use App\Livewire\Tutoring\ProfessorsList;
use App\Livewire\Tutoring\TutorDetails;
use App\Livewire\Tutoring\BookingProcess;
use App\Livewire\Tutoring\MesDemandes;
use App\Livewire\Tutoring\DemandeDetails;
use App\Livewire\Tutoring\RegisterProfesseur;

/*
|--------------------------------------------------------------------------
| Public pages
|--------------------------------------------------------------------------
*/
Route::get('/', LandingPage::class);
Route::get('/services', ServicesPage::class);
Route::get('/contact', ContactPage::class);

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::get('/connexion', LoginPage::class);
Route::post('/connexion', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// Ajouter les routes avec les noms attendus par la landing page
Route::get('/login', LoginPage::class)->name('login');
Route::get('/register', Register::class)->name('register');

Route::get('/inscription', Register::class);
Route::get('/inscriptionClient', RegisterClientPage::class);
Route::get('/inscriptionIntervenant', RegisterIntervenantPage::class);
Route::post('/register-client', [RegisterController::class, 'store'])->name('register.store');

/*
|--------------------------------------------------------------------------
| Profil
|--------------------------------------------------------------------------
*/
Route::get('/profil', ProfilClient::class);

/*
|--------------------------------------------------------------------------
| Babysitter - Public
|--------------------------------------------------------------------------
*/
Route::get('/liste-babysitter', ListeBabysitter::class)->name('liste.babysitter');
Route::get('/babysitter-profile/{id}', BabysitterProfilePage::class);
Route::get('/babysitter-booking/{id}', BabysitterBooking::class);
Route::get('/inscriptionBabysitter', BabysitterRegistration::class)->name('inscription.babysitter');
Route::get('/babysitter-registration-success', BabysitterRegistrationSuccess::class);

/*
|--------------------------------------------------------------------------
| Tutoring - Public
|--------------------------------------------------------------------------
*/
Route::get('/services/professors-list', ProfessorsList::class)->name('professors-list');
Route::get('/professeurs/{id}', TutorDetails::class)->name('professeurs.details');
Route::get('/reservation/{service}', BookingProcess::class)->name('reservation.create');
Route::get('/inscriptionProfesseur', RegisterProfesseur::class);

/*
|--------------------------------------------------------------------------
| Pet Keeping - Public
|--------------------------------------------------------------------------
*/
Route::prefix('pet-keeping')->group(function () {
    Route::get('search-service', PetKeepingService::class);
    Route::get('book', PetkeeperBooking::class);
});

/*
|--------------------------------------------------------------------------
| Pet Keeper
|--------------------------------------------------------------------------
*/
Route::prefix('pet-keeper')->group(function () {
    Route::get('inscription', PetKeeperRegistration::class);
    Route::get('profile', PetKeeperProfile::class);
    Route::get('dashboard', PetKeeperDashboard::class);
});

/*
|--------------------------------------------------------------------------
| Authenticated routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Tutoring
    Route::get('/tutoring/dashboard', Dashboard::class)->name('tutoring.dashboard');
    Route::get('/tutoring/requests', MesDemandes::class)->name('tutoring.requests');
    Route::get('/tutoring/demande/{id}', DemandeDetails::class)->name('tutoring.request.details');

    // Intervenant
    Route::get('/intervenant/hub', IntervenantHub::class)->name('intervenant.hub');

    // Babysitter
    Route::get('/babysitter/dashboard', BabysitterDashboard::class)->name('babysitter.dashboard');
    Route::get('/babysitter/profile', BabysitterProfile::class)->name('babysitter.profile');
});
