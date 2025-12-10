

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
use App\Livewire\Babysitter\ListeBabysitter;
use App\Livewire\Babysitter\BabysitterProfilePage;
use App\Livewire\Babysitter\BabysitterBooking;



Route::get('/', LandingPage::class);
Route::get('/services', ServicesPage::class);
Route::get('/contact', ContactPage::class);
Route::get('/connexion', LoginPage::class);
Route::get('/inscription', Register::class);
Route::get('/inscriptionIntervenant', RegisterIntervenantPage::class);
Route::get('/inscriptionClient', RegisterClientPage::class);
Route::get('/liste-babysitter', ListeBabysitter::class);
Route::get('/babysitter-profile/{id}', BabysitterProfilePage::class);
Route::get('/babysitter-booking/{id}', BabysitterBooking::class);
// Client registration POST route
Route::post('/register-client', [RegisterController::class, 'store'])->name('register.store');
Route::post('/connexion', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
Route::get('/inscriptionBabysitter', BabysitterRegistration::class)->name('inscription.babysitter');
