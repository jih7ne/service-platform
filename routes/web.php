<?php

// Auth Controllers
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;

// Shared Components
use App\Livewire\Shared\ContactPage;
use App\Livewire\Shared\FeedbackComponent;
use App\Livewire\Shared\IntervenantHub;
use App\Livewire\Shared\LandingPage;
use App\Livewire\Shared\LoginPage;
use App\Livewire\Shared\ProfilClient;
use App\Livewire\Shared\Register;
use App\Livewire\Shared\RegisterClientPage;
use App\Livewire\Shared\RegisterIntervenantPage;
use App\Livewire\Shared\ServicesPage;

// Admin Components
use App\Livewire\Shared\Admin\AdminDashboard;
use App\Livewire\Shared\Admin\AdminIntervenants;
use App\Livewire\Shared\Admin\AdminUsers;
use App\Livewire\Shared\Admin\IntervenantDetails;
use App\Livewire\Shared\Admin\ReclamationDetails;
use App\Livewire\Shared\Admin\ReclamationsList;
use App\Livewire\Shared\Admin\TraiterReclamation;

// Client Components
use App\Livewire\Client\MesAvis;
use App\Livewire\Client\MesReclamations;

// Tutoring Components
use App\Livewire\Tutoring\AvisPage as TutoringAvisPage;
use App\Livewire\Tutoring\BookingProcess;
use App\Livewire\Tutoring\ClientDetails;
use App\Livewire\Tutoring\Dashboard;
use App\Livewire\Tutoring\DemandeDetails;
use App\Livewire\Tutoring\DisponibilitesPage as TutoringDisponibilitesPage;
use App\Livewire\Tutoring\MesClients;
use App\Livewire\Tutoring\MesCours;
use App\Livewire\Tutoring\MesDemandes;
use App\Livewire\Tutoring\MonProfil;
use App\Livewire\Tutoring\ProfessorsList;
use App\Livewire\Tutoring\RegisterProfesseur;
use App\Livewire\Tutoring\StudentProfile;
use App\Livewire\Tutoring\TutorDetails;

// Babysitter Components
use App\Livewire\Babysitter\AvisPage as BabysitterAvisPage;
use App\Livewire\Babysitter\BabysitterBooking;
use App\Livewire\Babysitter\BabysitterDashboard;
use App\Livewire\Babysitter\BabysitterProfile;
use App\Livewire\Babysitter\BabysitterProfilePage;
use App\Livewire\Babysitter\BabysitterRegistration;
use App\Livewire\Babysitter\DemandesInterface;
use App\Livewire\Babysitter\FeedbackBabysitter;
use App\Livewire\Babysitter\ListeBabysitter;

// Pet Keeping Components
use App\Livewire\PetKeeper\PetKeeperAvis;
use App\Livewire\PetKeeping\AddPetKeepingService;
use App\Livewire\PetKeeping\PetKeeperDashboard;
use App\Livewire\PetKeeping\PetKeeperMissions;
use App\Livewire\PetKeeping\PetKeeperProfile;
use App\Livewire\PetKeeping\PetKeeperRegistration;
use App\Livewire\PetKeeping\PetkeepingServiceBooking;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use App\Livewire\PetKeeping\DisponibilitesPetKeeper;
use App\Livewire\PetKeeping\PetKeeperMissionDetails;
use App\Livewire\Babysitter\BabysitterRegistrationSuccess;
use App\Livewire\PetKeeping\MesClients as PetKeeperClients;
use App\Livewire\PetKeeping\MyServices as MyPetKeepingServices;
use App\Livewire\PetKeeping\SearchService as PetKeepingService;
use App\Livewire\PetKeeping\SingleService as SinglePetKeepingService;
use App\Livewire\Babysitter\DisponibilitesPage as BabysitterDisponibilitesPage;






// Public Routes
Route::get('/', LandingPage::class)->name('home');
Route::get('/services', ServicesPage::class)->name('services');

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

// Public Pet Keeping Routes
Route::prefix('pet-keeping')->group(function () {
    Route::get('search-service', PetKeepingService::class)->name('pet-keeping.search-service');
    Route::get('book/{IdService}', PetkeepingServiceBooking::class)->name('pet-keeper.book');
});

// ============================================================================
// AUTH ROUTES
// ============================================================================

Route::post('/register-client', [RegisterController::class, 'store'])->name('register.store');
Route::post('/connexion', [\App\Http\Controllers\Api\Auth\LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// ============================================================================
// PROTECTED ROUTES
// ============================================================================

Route::middleware(['auth'])->group(function () {
    
    // Profile & Client Routes
    Route::get('/profil', ProfilClient::class)->name('profile');
    Route::get('/mes-reclamations', MesReclamations::class)->name('client.reclamations');
    Route::get('/mes-avis', MesAvis::class)->name('mes-avis');
    Route::get('/mes-demandes', \App\Livewire\Client\MesDemandes::class)->name('client.mes-demandes');
    
    // Intervenant Hub
    Route::get('/intervenant/hub', IntervenantHub::class)->name('intervenant.hub');
    
    // Tutoring Routes
    Route::prefix('tutoring')->name('tutoring.')->group(function () {
        Route::get('dashboard', Dashboard::class)->name('dashboard');
        Route::get('requests', MesDemandes::class)->name('requests');
        Route::get('demande/{id}', DemandeDetails::class)->name('request.details');
        Route::get('client/{id}', ClientDetails::class)->name('client.details');
        Route::get('mes-clients', MesClients::class)->name('clients');
        Route::get('profil-candidat/{id}', StudentProfile::class)->name('student.profile');
        Route::get('mes-cours', MesCours::class)->name('courses');
        Route::get('mon-profil', MonProfil::class)->name('profile');
        Route::get('disponibilites', TutoringDisponibilitesPage::class)->name('disponibilites');
        Route::get('avis', TutoringAvisPage::class)->name('avis');
    });
    
    // Babysitter Routes
    Route::prefix('babysitter')->name('babysitter.')->group(function () {
        Route::get('dashboard', BabysitterDashboard::class)->name('dashboard');
        Route::get('disponibilites', BabysitterDisponibilitesPage::class)->name('disponibilites');
        Route::get('avis', BabysitterAvisPage::class)->name('avis');
        Route::get('profile', BabysitterProfile::class)->name('profile');
        Route::get('demandes', DemandesInterface::class)->name('demandes');
        Route::get('feedback/{id}', FeedbackBabysitter::class)->name('feedback');
    });
    
    // Pet Keeper Routes (Provider)
    Route::prefix('pet-keeper')->name('petkeeper.')->group(function () {
        Route::get('inscription', PetKeeperRegistration::class)->name('inscription');
        Route::get('profile', PetKeeperProfile::class)->name('profile');
        Route::get('dashboard', PetKeeperDashboard::class)->name('dashboard');
        Route::get('mission/{id}', PetKeeperMissionDetails::class)->name('mission.show');
        Route::get('missions', PetKeeperMissions::class)->name('missions');
        Route::get('dashboard/services', MyPetKeepingServices::class)->name('services');
        Route::get('dashboard/service/{serviceId}', SinglePetKeepingService::class)->name('services.show');
        Route::get('dashboard/disponibilites', DisponibilitesPetKeeper::class)->name('disponibilites');
        Route::get('dashboard/clients', PetKeeperClients::class)->name('clients');
        Route::get('dashboard/add-service', AddPetKeepingService::class)->name('addservice');
        Route::get('dashboard/mon-avis/{idService}/{demandeId}/{auteurId}/{cibleId}/{typeAuteur?}', PetKeeperAvis::class)->name('avis');
    });
    

    
    // Feedback Routes
    Route::get('/feedback/test', FeedbackComponent::class)->name('feedback.test');
    Route::get('/feedback/{idService}/{demandeId}/{auteurId}/{cibleId}/{typeAuteur?}', FeedbackComponent::class)->name('feedback.form');
    Route::get('/feedback/babysitter/{idService}/{demandeId}/{auteurId}/{cibleId}/{typeAuteur?}', FeedbackComponent::class)->name('feedback.babysitter');
    Route::get('/feedback/tutoring/{idService}/{demandeId}/{auteurId}/{cibleId}/{typeAuteur?}', FeedbackComponent::class)->name('feedback.tutoring');
    Route::get('/feedback/pet-keeping/{idService}/{demandeId}/{auteurId}/{cibleId}/{typeAuteur?}', FeedbackComponent::class)->name('feedback.pet-keeping');

});

// ============================================================================
// ADMIN ROUTES (PROTECTED BY CUSTOM MIDDLEWARE)
// ============================================================================

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/users', AdminUsers::class)->name('users');
    Route::get('/reclamations', ReclamationsList::class)->name('reclamations');
    Route::get('/reclamations/{id}/details', ReclamationDetails::class)->name('reclamations.details');
    Route::get('/reclamations/{id}/traiter', TraiterReclamation::class)->name('reclamations.traiter');
    Route::get('/intervenants', AdminIntervenants::class)->name('intervenants');
    Route::get('/intervenant/{idintervenant}/{idservice}', IntervenantDetails::class)->name('intervenant.details');
});



