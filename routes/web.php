

<?php
use App\Livewire\Shared\LandingPage;
use App\Livewire\Shared\ServicesPage;
use App\Livewire\Shared\ContactPage;
use App\Livewire\Shared\LoginPage;
use App\Livewire\Shared\Register;
use App\Livewire\Shared\RegisterClientPage;
use App\Livewire\Shared\RegisterIntervenantPage;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Babysitter\BabysitterRegistration;
use App\Http\Controllers\Api\Auth\GoogleAuthController;


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
Route::get('/inscriptionBabysitter', BabysitterRegistration::class)->name('inscription.babysitter');
Route::get('/inscriptionProfesseur', \App\Livewire\Tutoring\RegisterProfesseur::class);
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
