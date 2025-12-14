

<?php

use App\Livewire\Shared\Register;
use App\Livewire\Shared\LoginPage;
use App\Livewire\Shared\ContactPage;
use App\Livewire\Shared\LandingPage;
use App\Livewire\Tutoring\Dashboard;
use App\Livewire\Shared\ServicesPage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Tutoring\MesDemandes;
use App\Livewire\Shared\IntervenantHub;
use App\Livewire\Tutoring\TutorDetails;
use App\Livewire\Tutoring\BookingProcess;
use App\Livewire\Tutoring\DemandeDetails;
use App\Livewire\Tutoring\ProfessorsList;


use App\Livewire\Shared\RegisterClientPage;
use App\Livewire\PetKeeping\PetkeeperBooking;
use App\Livewire\PetKeeping\PetKeeperProfile;
use App\Livewire\PetKeeping\PetKeeperDashboard;
use App\Livewire\Shared\RegisterIntervenantPage;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Livewire\PetKeeping\PetKeeperRegistration;


//use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Livewire\PetKeeping\SearchService as PetKeepingService;
use App\Livewire\Babysitter\ListeBabysitter;
use App\Livewire\Babysitter\BabysitterProfilePage;
use App\Livewire\Babysitter\BabysitterBooking;
use App\Livewire\Babysitter\BabysitterRegistration;
use App\Livewire\Babysitter\BabysitterRegistrationSuccess;
use App\Livewire\Babysitter\BabysitterDashboard;
use App\Livewire\Babysitter\BabysitterProfile;


Route::get('/', LandingPage::class);
Route::get('/services', ServicesPage::class);
Route::get('/contact', ContactPage::class);
Route::get('/connexion', LoginPage::class);
Route::get('/inscription', Register::class);
Route::get('/inscriptionIntervenant', RegisterIntervenantPage::class);
Route::get('/inscriptionClient', RegisterClientPage::class);

Route::get('/profil', \App\Livewire\Shared\ProfilClient::class);

Route::get('/liste-babysitter', ListeBabysitter::class)->name('liste.babysitter');
Route::get('/babysitter-profile/{id}', BabysitterProfilePage::class);
Route::get('/babysitter-booking/{id}', BabysitterBooking::class);



// Client registration POST route
Route::post('/register-client', [RegisterController::class, 'store'])->name('register.store');
Route::post('/connexion', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
Route::get('/inscriptionBabysitter', BabysitterRegistration::class)->name('inscription.babysitter');
Route::get('/babysitter-registration-success', BabysitterRegistrationSuccess::class)->name('babysitter-registration-success');
Route::get('/inscriptionProfesseur', \App\Livewire\Tutoring\RegisterProfesseur::class);


Route::prefix('pet-keeping')->group(function (){
    Route::get('search-service', PetKeepingService::class);
    Route::get('book', PetkeeperBooking::class);
});

Route::prefix('pet-keeper')->group(function(){
    Route::get('inscription', PetKeeperRegistration::class);
    Route::get('profile', PetKeeperProfile::class);
    Route::get('dashboard', PetKeeperDashboard::class);
});

//Route::middleware(['auth'])->group(function () {
     Route::get('/tutoring/dashboard', Dashboard::class)->name('tutoring.dashboard');
// Tutoring routes (client side)
Route::get('/services/professors-list', ProfessorsList::class)->name('professors-list');
Route::get('/professeurs/{id}', TutorDetails::class)->name('professeurs.details');
Route::get('/reservation/{service}', BookingProcess::class)->name('reservation.create');


Route::middleware(['auth'])->group(function () {
    Route::get('/tutoring/dashboard', Dashboard::class)->name('tutoring.dashboard');
    Route::get('/intervenant/hub', IntervenantHub::class)->name('intervenant.hub');
    
    // Babysitter routes
    Route::get('/babysitter/dashboard', BabysitterDashboard::class)->name('babysitter.dashboard');
    Route::get('/babysitter/profile', BabysitterProfile::class)->name('babysitter.profile');
    Route::get('/tutoring/demande/{id}', DemandeDetails::class)->name('tutoring.request.details');
    Route::get('/tutoring/requests', MesDemandes::class)->name('tutoring.requests');
});

