<?php

use App\Livewire\Client\MesAvis;

// Auth Controllers
use App\Livewire\Shared\AvisPage;
use App\Livewire\Shared\Feedback;

// Shared Livewire Components
use App\Livewire\Shared\Register;
use App\Livewire\Shared\LoginPage;
use App\Livewire\Tutoring\MesCours;
use App\Livewire\Shared\LandingPage;
use App\Livewire\Tutoring\Dashboard;
use App\Livewire\Tutoring\MonProfil;
use App\Livewire\Shared\ProfilClient;
use App\Livewire\Shared\ServicesPage;
use App\Livewire\Tutoring\MesClients;
use Illuminate\Support\Facades\Route;

// Tutoring Livewire Components

use App\Livewire\Tutoring\MesDemandes;
use App\Livewire\Shared\IntervenantHub;
use App\Livewire\Tutoring\TutorDetails;
use App\Livewire\Client\MesReclamations;
use App\Livewire\Tutoring\ClientDetails;
use App\Livewire\PetKeeper\PetKeeperAvis;
use App\Livewire\Shared\Admin\AdminUsers;
use App\Livewire\Tutoring\BookingProcess;
use App\Livewire\Tutoring\DemandeDetails;
use App\Livewire\Tutoring\ProfessorsList;
use App\Livewire\Tutoring\StudentProfile;
use App\Livewire\Shared\RegisterClientPage;
use App\Livewire\Babysitter\ListeBabysitter;
use App\Livewire\PetKeeping\PetKeeperProfile;
use App\Livewire\Shared\Admin\AdminDashboard;

// Babysitter Livewire Components
use App\Livewire\Tutoring\RegisterProfesseur;
use App\Livewire\Babysitter\BabysitterBooking;
use App\Livewire\Babysitter\BabysitterProfile;
use App\Livewire\PetKeeping\PetKeeperMissions;
use App\Livewire\PetKeeping\PetKeeperDashboard;
use App\Livewire\Shared\Admin\ReclamationsList;
use App\Livewire\Babysitter\BabysitterDashboard;
use App\Livewire\Shared\Admin\AdminIntervenants;

// PetKeeping Livewire Components
use App\Livewire\Shared\RegisterIntervenantPage;
use App\Livewire\PetKeeping\AddPetKeepingService;
use App\Livewire\Shared\Admin\IntervenantDetails;
use App\Livewire\Shared\Admin\ReclamationDetails;
use App\Livewire\Shared\Admin\TraiterReclamation;
use App\Http\Controllers\Api\Auth\LoginController;

use App\Livewire\Babysitter\BabysitterProfilePage;
use App\Livewire\PetKeeping\PetKeeperRegistration;
use App\Livewire\Babysitter\BabysitterRegistration;



// 1. AJOUTE CETTE LIGNE TOUT EN HAUT DU FICHIER (avec les autres use)

// ... le reste de ton code ...

// 2. AJOUTE CETTE LIGNE TOUT EN BAS (en dehors des groupes pour tester facilement)
Route::get('/mes-demandes', \App\Livewire\Client\MesDemandes::class)->name('client.mes-demandes');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use App\Livewire\PetKeeping\DisponibilitesPetKeeper;
use App\Livewire\PetKeeping\PetKeeperMissionDetails;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Livewire\PetKeeping\PetkeepingServiceBooking;
use App\Livewire\Babysitter\BabysitterRegistrationSuccess;
use App\Livewire\PetKeeping\MesClients as PetKeeperClients;
use App\Livewire\PetKeeping\MyServices as MyPetKeepingServices;
use App\Livewire\PetKeeping\SearchService as PetKeepingService;
use App\Livewire\PetKeeping\SingleService as SinglePetKeepingService;
use App\Livewire\Tutoring\DisponibilitesPage as TutoringDisponibilitesPage;
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

// Auth Routes
Route::post('/register-client', [RegisterController::class, 'store'])->name('register.store');
Route::post('/connexion', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// Pet Keeping Routes - UNIQUEMENT ICI, PAS DE DOUBLONS
Route::prefix('pet-keeping')->group(function (){
    Route::get('search-service', PetKeepingService::class)->name('pet-keeping.search-service');
    Route::get('book/{IdService}', PetKeepingServiceBooking::class)->name('pet-keeper.book');
});

// Pet Keeper Routes (Provider)
Route::prefix('pet-keeper')->name('petkeeper.')->group(function () {
    Route::get('inscription', PetKeeperRegistration::class)->name('inscription');
    Route::get('profile', PetKeeperProfile::class)->name('profile');
    Route::get('dashboard', PetKeeperDashboard::class)->name('dashboard');
    Route::get('mission/{id}', PetKeeperMissionDetails::class)->name('mission.show');
    Route::get('missions', PetKeeperMissions::class)->name('missions');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Profile
    Route::get('/profil', ProfilClient::class)->name('profile');
    Route::get('/mes-reclamations', MesReclamations::class)->name('client.reclamations');
    Route::get('/mes-avis', MesAvis::class)->name('mes-avis');
    
    // Intervenant Hub
    Route::get('/intervenant/hub', IntervenantHub::class)->name('intervenant.hub');
    
    // Tutoring
    Route::get('/tutoring/dashboard', Dashboard::class)->name('tutoring.dashboard');
    Route::get('/tutoring/requests', MesDemandes::class)->name('tutoring.requests');
    Route::get('/tutoring/demande/{id}', DemandeDetails::class)->name('tutoring.request.details');
    Route::get('/tutoring/client/{id}', ClientDetails::class)->name('tutoring.client.details');
    Route::get('/tutoring/mes-clients', MesClients::class)->name('tutoring.clients');
    Route::get('/tutoring/profil-candidat/{id}', StudentProfile::class)->name('tutoring.student.profile');
    Route::get('/tutoring/mes-cours', MesCours::class)->name('tutoring.courses');
    Route::get('/tutoring/mon-profil', MonProfil::class)->name('tutoring.profile');
    Route::get('/tutoring/disponibilites', TutoringDisponibilitesPage::class)->name('tutoring.disponibilites');
    
    // Babysitter
    Route::get('/babysitter/dashboard', BabysitterDashboard::class)->name('babysitter.dashboard');
    Route::get('/babysitter/disponibilites', BabysitterDisponibilitesPage::class)->name('babysitter.disponibilites');
    Route::get('/babysitter/avis', AvisPage::class)->name('babysitter.avis');
    Route::get('/babysitter/profile', BabysitterProfile::class)->name('babysitter.profile');
});



    // Maintenant cette ligne va fonctionner car l'import est correct en haut
    //Route::get('mission/{id}', PetKeeperMissionDetails::class)->name('mission.details');

// Pet Keeping Routes (Client)
Route::prefix('pet-keeping')->group(function (){
    Route::get('search-service', PetKeepingService::class)->name('pet-keeping.search-service');
    Route::get('book/{IdService}', PetKeepingServiceBooking::class)->name('pet-keeper.book');
});

// Pet Keeper Routes (Provider)
Route::prefix('pet-keeper')->name('petkeeper.')->group(function () {
    Route::get('inscription', PetKeeperRegistration::class)->name('inscription');
    Route::get('profile', PetKeeperProfile::class)->name('profile');
    Route::get('dashboard', PetKeeperDashboard::class)->name('dashboard');
    Route::get('mission/{id}', PetKeeperMissionDetails::class)->name('mission.show');
    Route::get('/dashboard/services', MyPetKeepingServices::class)->name('services');
    Route::get('dashboard/disponibilites', DisponibilitesPetKeeper::class)->name('disponibilites');
    Route::get('/dashboard/clients', PetKeeperClients::class)->name('clients');
    Route::get('/dashboard/service/{serviceId}', SinglePetKeepingService::class)->name('services.show');
    Route::get('/dashboard/add-service', AddPetKeepingService::class)->name('addservice');
    Route::get('/dashboard/mon-avis/{idService}/{demandeId}/{auteurId}/{cibleId}/{typeAuteur?}', PetKeeperAvis::class);

});
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

Route::get('/feedback/test', Feedback::class)->name('feedback.test');

// Route avec paramètres (pour utilisation réelle)
Route::get('/feedback/{demandeId}/{auteurId}/{cibleId}/{typeAuteur?}', Feedback::class)
    ->name('feedback.form');