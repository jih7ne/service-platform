<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;

// Shared
use App\Livewire\Shared\Register;
use App\Livewire\Shared\LoginPage;
use App\Livewire\Shared\ContactPage;
use App\Livewire\Shared\LandingPage;
use App\Livewire\Shared\ServicesPage;
use App\Livewire\Shared\IntervenantHub;
use App\Livewire\Shared\RegisterClientPage;
use App\Livewire\Shared\RegisterIntervenantPage;

// Tutoring
use App\Livewire\Tutoring\Dashboard;
use App\Livewire\Tutoring\MesDemandes;
use App\Livewire\Tutoring\TutorDetails;
use App\Livewire\Tutoring\BookingProcess;
use App\Livewire\Tutoring\DemandeDetails;
use App\Livewire\Tutoring\ProfessorsList;
use App\Livewire\Tutoring\RegisterProfesseur;

// PetKeeping
use App\Livewire\PetKeeping\SearchService as PetKeepingService;
use App\Livewire\PetKeeping\PetkeeperBooking;
use App\Livewire\PetKeeping\PetKeeperProfile;
use App\Livewire\PetKeeping\PetKeeperDashboard;
use App\Livewire\PetKeeping\PetKeeperRegistration;
// Important : Importez le nouveau composant détails
use App\Livewire\PetKeeperMissionDetails; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', LandingPage::class);
Route::get('/services', ServicesPage::class);
Route::get('/contact', ContactPage::class);
Route::get('/connexion', LoginPage::class);
Route::get('/inscription', Register::class);
Route::get('/inscriptionIntervenant', RegisterIntervenantPage::class);
Route::get('/inscriptionClient', RegisterClientPage::class);
Route::get('/inscriptionProfesseur', RegisterProfesseur::class);

// Auth POST routes
Route::post('/register-client', [RegisterController::class, 'store'])->name('register.store');
Route::post('/connexion', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// Groupe Pet Keeping (Client)
Route::prefix('pet-keeping')->group(function (){
    Route::get('search-service', PetKeepingService::class);
    Route::get('book', PetkeeperBooking::class);
});

// Groupe Pet Keeper (Prestataire)
Route::prefix('pet-keeper')->group(function(){
    Route::get('inscription', PetKeeperRegistration::class);
    Route::get('profile', PetKeeperProfile::class)->name('petkeeper.profile');
    
    // Le Dashboard
    Route::get('dashboard', PetKeeperDashboard::class)->name('petkeeper.dashboard');
    
    // La nouvelle route pour "Consulter" (URL: /pet-keeper/mission/1)
    Route::get('mission/{id}', PetKeeperMissionDetails::class)->name('petkeeper.mission.details');
});

// Routes protégées (Tutoring & Hub)
Route::middleware(['auth'])->group(function () {
    Route::get('/tutoring/dashboard', Dashboard::class)->name('tutoring.dashboard');
    Route::get('/intervenant/hub', IntervenantHub::class)->name('intervenant.hub');
    Route::get('/tutoring/demande/{id}', DemandeDetails::class)->name('tutoring.request.details');
    Route::get('/tutoring/requests', MesDemandes::class)->name('tutoring.requests');
});

// Routes publiques Tutoring
Route::get('/services/professors-list', ProfessorsList::class)->name('professors-list');
Route::get('/professeurs/{id}', TutorDetails::class)->name('professeurs.details');
Route::get('/reservation/{service}', BookingProcess::class)->name('reservation.create');