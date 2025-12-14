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


use App\Livewire\PetKeeping\PetKeepingServiceBooking;


// Auth Routes
Route::post('/register-client', [RegisterController::class, 'store'])->name('register.store');
Route::post('/connexion', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');




// Public Tutoring Routes
Route::get('/services/professors-list', ProfessorsList::class)->name('professors-list');
Route::get('/professeurs/{id}', TutorDetails::class)->name('professeurs.details');
Route::get('/reservation/{service}', BookingProcess::class)->name('reservation.create');

// Pet Keeping Routes (Client)
Route::prefix('pet-keeping')->group(function (){
    Route::get('search-service', PetKeepingService::class);
    Route::get('book/{IdService}', PetKeepingServiceBooking::class)->name('pet-keeper.book');
});

// Pet Keeper Routes (Provider)
Route::prefix('pet-keeper')->name('petkeeper.')->group(function () {
    Route::get('inscription', PetKeeperRegistration::class)->name('inscription');
    Route::get('profile', PetKeeperProfile::class)->name('profile');
    Route::get('dashboard', PetKeeperDashboard::class)->name('dashboard');
    Route::get('mission/{id}', PetKeeperMissionDetails::class)->name('mission.details');
});